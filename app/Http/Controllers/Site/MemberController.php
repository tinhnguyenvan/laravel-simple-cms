<?php

namespace App\Http\Controllers\Site;

use App\Jobs\MemberJob;
use App\Models\Media;
use App\Models\Member;
use App\Models\MemberSocialAccount;
use App\Models\RolePermission;
use App\Services\ClassifiedService;
use App\Services\ConfigService;
use App\Services\MediaService;
use App\Services\MemberService;
use App\Services\PostService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class MemberController.
 *
 * @property MemberService $memberService
 * @property PostService $postService
 * @property ClassifiedService $classifiedService
 * @property MediaService $mediaService
 */
final class MemberController extends SiteController
{
    public function __construct(
        PostService $postService,
        ClassifiedService $classifiedService,
        MemberService $memberService,
        MediaService $mediaService
    ) {
        parent::__construct();
        $this->postService = $postService;
        $this->classifiedService = $classifiedService;
        $this->memberService = $memberService;
        $this->mediaService = $mediaService;
        $manifest = @json_decode(file_get_contents(public_path('layout/' . $this->theme . '/manifest.json')), true);
        $this->data['manifest'] = $manifest;
    }

    public function index()
    {
        $data = [
            'member' => Auth::guard(RolePermission::GUARD_NAME_WEB)->user(),
            'active_menu' => '',
            'title' => trans('member.title_profile'),
        ];

        return view('site.member.index', $this->render($data));
    }

    public function login()
    {
        if (Auth::guard(RolePermission::GUARD_NAME_WEB)->check()) {
            return redirect(base_url('member'));
        }

        $data = [
            'active_menu' => ''
        ];

        return view('site.member.login', $this->render($data));
    }

    public function handleLogin(Request $request)
    {
        if (Auth::guard(RolePermission::GUARD_NAME_WEB)->check()) {
            return redirect(base_url('member'));
        }

        $params = $request->only('email', 'password');
        $credentials = $params;
        $credentials['status'] = Member::STATUS_ACTIVE;

        if (Auth::guard(RolePermission::GUARD_NAME_WEB)->attempt($credentials)) {
            $member = Member::query()->where('id', auth(RolePermission::GUARD_NAME_WEB)->id())->first();
            $conditionSocial = [
                'member_id' => $member->id,
                'provider_id' => $member->id,
                'provider' => MemberSocialAccount::PROVIDER_EMAIL,
            ];
            $memberSocialAccount = MemberSocialAccount::query()->where($conditionSocial)->first();
            if (!empty($myMember) && !empty($memberSocialAccount)) {
                /** @var Member $member */
                auth(RolePermission::GUARD_NAME_WEB)->login($member);
                return redirect(base_url('member'));
            } else {
                $request->session()->flash('error', trans('member.error_member_not_exist'));
            }
        } else {
            $request->session()->flash('error', trans('member.login.error'));
        }

        return back()->withErrors(trans('member.login.not_exist'));
    }

    public function register()
    {
        if (Auth::guard(RolePermission::GUARD_NAME_WEB)->check()) {
            return redirect(base_url('member'));
        }

        $data = [
            'active_menu' => ''
        ];

        return view('site.member.register', $this->render($data));
    }

    public function handleRegister(Request $request)
    {
        $isValidator = false;

        if (Auth::guard(RolePermission::GUARD_NAME_WEB)->check()) {
            return redirect(base_url('member'));
        }

        $request->validate([
            'email' => 'required|min:5|max:255',
            'password' => 'required|confirmed|min:1|max:255',
            'password_confirmation' => 'required|same:password|min:6',
        ]);

        $params = $request->only(['email', 'password', 'password_confirmation']);
        $member = Member::query()->where('email', $params['email'])->first();
        if (!empty($member->id)) {
            if (empty($member->socials)) {
                $isValidator = true;
            }

            if (empty(!$member->socials)) {
                foreach ($member->socials as $social) {
                    if ($social->provider == MemberSocialAccount::PROVIDER_EMAIL) {
                        $isValidator = false;
                        break;
                    }

                    $isValidator = true;
                }
            }
        }

        if ($isValidator) {
            if (empty($member)) {
                $member = $this->memberService->create($params);
            } else {
                $params['status'] = Member::STATUS_WAITING_ACTIVE;
                $params['password'] = Hash::make($params['password']);
                $this->memberService->update($member->id, $params);
            }

            if (!empty($member->id)) {
                MemberSocialAccount::query()->create([
                    'member_id' => $member->id,
                    'provider_id' => $member->id,
                    'provider' => MemberSocialAccount::PROVIDER_EMAIL,
                ]);

                // send mail active
                $this->memberService->activeMember($member);

                $request->session()->flash('success', trans('common.add.success'));

                return redirect(base_url('member/register'), 302);
            } else {
                $message = trans('common.add.error');
            }
        } else {
            $message = trans('member.error_member_exist');
        }

        $request->session()->flash('error', $message);
        return back()->withInput();
    }

    public function updateProfile()
    {
        $data = [
            'member' => Auth::guard(RolePermission::GUARD_NAME_WEB)->user(),
            'title' => trans('member.title_update_profile'),
            'active_menu' => 'update-profile'
        ];

        return view('site.member.update_profile', $this->render($data));
    }

    public function handleUpdateProfile(Request $request)
    {
        $params = $request->all();

        $request->validate([
            'last_name' => 'required|min:5|max:255',
        ]);

        // remove image
        if (!empty($params['file_remove'])) {
            $params['image_id'] = 0;
            $params['image_url'] = '';
        }

        $id = auth(RolePermission::GUARD_NAME_WEB)->id();
        $result = $this->memberService->update($id, $params);

        if (empty($result['message'])) {
            $this->mediaService->uploadModule([
                'file' => $request->file('file'),
                'object_type' => Media::OBJECT_TYPE_MEMBER,
                'object_id' => $id,
            ]);

            $request->session()->flash('success', trans('common.edit.success'));
            return redirect(base_url('member/update-profile'), 302);
        }

        return back()->withErrors($result['message']);
    }

    public function changePassword()
    {
        $data = [
            'title' => trans('member.title_change_password'),
            'active_menu' => 'change-password'
        ];

        return view('site.member.change_password', $this->render($data));
    }

    public function handleChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password|min:6',
        ]);

        $id = auth(RolePermission::GUARD_NAME_WEB)->id();
        $params = $request->only(['password', 'password_confirm']);

        $myUser = Member::query()->findOrFail($id);
        $myUser->password = Hash::make($params['password']);
        $myUser->save();

        $request->session()->flash('success', trans('member.update.password_success'));

        return redirect(base_url('member'), 302);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function activeMail(Request $request)
    {
        $params = $request->only(['email', 'code']);
        $condition = [
            'email' => $params['email'],
            'status' => Member::STATUS_WAITING_ACTIVE,
        ];

        $member = Member::query()->where($condition)->first();

        if (!empty($member->id)) {
            $conditionSocial = [
                'member_id' => $member->id,
                'provider_id' => $member->id,
                'provider' => MemberSocialAccount::PROVIDER_EMAIL,
            ];
            $memberSocialAccountAccount = MemberSocialAccount::query()->where($conditionSocial)->first();
            if (!empty($memberSocialAccountAccount)) {
                $member->status = Member::STATUS_ACTIVE;
                $member->updated_at = now();
                $member->save();

                // send mail
                MemberJob::dispatch(['action' => MemberJob::ACTION_ACTIVE_SUCCESS, 'id' => $member->id]);

                // redirect message
                $request->session()->flash('success', trans('member.active.success'));

                return redirect(base_url('member/login'), 302);
            } else {
                $request->session()->flash('error', trans('member.error_member_not_exist'));
            }
        } else {
            $request->session()->flash('error', trans('member.active.error'));
        }

        return redirect(base_url('member/login'));
    }

    public function forgot()
    {
        $data = [
            'title' => trans('member.title_forgot'),
            'active_menu' => ''
        ];

        return view('site.member.forgot', $this->render($data));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function handleForgot(Request $request)
    {
        $params = $request->only(['email']);
        $condition = [
            'email' => $params['email'],
            'status' => Member::STATUS_ACTIVE,
        ];

        $member = Member::query()->where($condition)->where('password', '!=', '')->first();

        if (!empty($member->id)) {
            $conditionSocial = [
                'member_id' => $member->id,
                'provider_id' => $member->id,
                'provider' => MemberSocialAccount::PROVIDER_EMAIL,
            ];
            $memberSocialAccount = MemberSocialAccount::query()->where($conditionSocial)->first();
            if (!empty($memberSocialAccount)) {
                $password = substr(uniqid(), 0, 10);
                $member->updated_at = now();
                $member->password = Hash::make($password);
                $member->save();

                // send mail
                MemberJob::dispatch([
                    'action' => MemberJob::ACTION_FORGOT_PASSWORD,
                    'id' => $member->id,
                    'password' => $password
                ]);

                // redirect message
                $request->session()->flash('success', trans('member.forgot_password.success'));

                return redirect(base_url('member/login'), 302);
            } else {
                $message = trans('member.error_member_not_exist');
            }
        } else {
            $message = trans('member.forgot.empty');
        }

        $request->session()->flash('error', $message);
        return redirect(base_url('member/forgot'));
    }

    public function loginSocial($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial($provider)
    {
        try {
            $getInfo = Socialite::driver($provider)->user();
            $memberSocialAccountAccount = MemberSocialAccount::query()
                ->where('provider', $provider)
                ->where('provider_id', $getInfo->getId())
                ->first();

            if (!empty($memberSocialAccountAccount)) {
                $member = $memberSocialAccountAccount->member;
            } else {
                $email = $getInfo->getEmail() ?? $getInfo->getNickname();
                $memberSocialAccountAccount = new MemberSocialAccount([
                    'provider_id' => $getInfo->getId(),
                    'provider' => $provider
                ]);

                $member = Member::query()->where('email', $email)->first();

                if (!$member) {
                    $member = Member::query()->create([
                        'email' => $email,
                        'username' => $email,
                        'fullname' => $getInfo->getName(),
                        'image_url' => $getInfo->getAvatar(),
                    ]);
                }

                $memberSocialAccountAccount->member()->associate($member);
                $memberSocialAccountAccount->save();
            }

            if (!empty($member->id)) {
                /** @var Member $myMember */
                $myMember = Member::query()->where('id', $member->id)->first();
                auth(RolePermission::GUARD_NAME_WEB)->login($myMember);
            }
        } catch (Exception $e) {
        }

        return redirect()->to('/member');
    }

    public function logout()
    {
        Auth::guard(RolePermission::GUARD_NAME_WEB)->logout();
        return redirect(base_url('member/login'));
    }
}
