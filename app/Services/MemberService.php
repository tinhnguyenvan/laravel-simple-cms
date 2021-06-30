<?php
/**
 * @author: nguyentinh
 * @time: 10/29/19 4:05 PM
 */

namespace App\Services;

use App\Mail\MemberMail;
use App\Models\Config;
use App\Models\Member;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class MemberService.
 *
 * @property Member $model
 */
class MemberService extends BaseService
{
    public function __construct(Member $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function table()
    {
        return $this->model->getTable();
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function validator($params)
    {
        $error = [];

        if (empty($params['id'])) {
            $validator = Validator::make(
                $params,
                [
                    'username' => 'required|min:5|max:255|unique:' . $this->model->getTable(),
                    'password' => 'required|confirmed|min:1|max:255',
                ]
            );

            if ($validator->fails()) {
                static::convertErrorValidator($validator->errors()->toArray(), $error);
            }
        }

        return $error;
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function validatorAuth($params)
    {
        $error = [];

        $validator = Validator::make(
            $params,
            [
                'email' => 'required|min:5|max:255',
                'password' => 'required|min:1|max:255',
            ]
        );

        if ($validator->fails()) {
            static::convertErrorValidator($validator->errors()->toArray(), $error);
        }

        return $error;
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function auth($params)
    {
        $condition = [
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ];

        $myObject = Member::query()->where($condition)->first();

        if (!empty($myObject->id)) {
            $payload = [
                'iss' => env('APP_NAME'), // Issuer of the token
                'sub' => $data['id'] ?? time(), // Subject of the token
                'iat' => time(), // Time when JWT was issued.
                'exp' => time() + env('JWT_TOKEN_EXPIRED'), // Expiration time
                'data' => $myObject->toArray(),
            ];

            $token = JWT::encode($payload, env('JWT_SECRET'));

            return [
                'user_id' => $myObject->id,
                'fullname' => $myObject->name,
                'email' => $myObject->email,
                'token' => $token,
                'avatar' => '',
            ];
        }

        return [
            'message' => 'error_not_found_data',
        ];
    }

    public function beforeSave(&$formData = [], $isNews = false)
    {
        if (empty($formData['id']) && !empty($formData['password'])) {
            $formData['password'] = Hash::make($formData['password']);
        }

        if ($isNews) {
            $formData['username'] = $formData['email'];
            $formData['status'] = Member::STATUS_WAITING_ACTIVE;
        }

        $fullName = '';

        if (!empty($formData['last_name'])) {
            $fullName .= $formData['last_name'];
        }

        if (!empty($formData['first_name'])) {
            $fullName .= ' ' . $formData['first_name'];
        }

        $formData['fullname'] = $fullName;
    }

    /**
     * @param $params
     * @return object|int
     */
    public function create($params)
    {
        $this->beforeSave($params, true);
        $myObject = new Member($params);
        $params['status'] = Member::STATUS_WAITING_ACTIVE;

        if ($myObject->save($params)) {
            return $myObject;
        }

        return 0;
    }

    /**
     * @param $id
     * @param $params
     *
     * @return array|bool
     */
    public function update($id, $params)
    {
        $params['id'] = $id;
        $this->beforeSave($params);

        return Member::query()->findOrFail($id)->update($params);
    }

    public function activeMember($myObject)
    {
        if (!empty($myObject->email_verified_at)) {
            return null;
        }

        $config = Config::query()->where('name', 'company_name')->first();
        Mail::send(
            new MemberMail(
                [
                    'action' => MemberMail::ACTION_ACTIVE_MEMBER,
                    'name' => $myObject->email,
                    'email' => $myObject->email,
                    'company_name' => $config->value ?? '',
                    'link_active' => $this->linkActive($myObject),
                ]
            )
        );
    }

    /**
     * @param $user
     *
     * @return string
     */
    public function linkActive($user)
    {
        return base_url('member/activemail?email=' . $user->email . '&code=' . sha1(base64_encode($user->id)));
    }
}
