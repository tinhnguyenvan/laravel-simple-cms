<?php

namespace App\Http\Controllers\Site;

use App\Models\Classified;
use App\Models\ClassifiedCategory;
use App\Models\ClassifiedImage;
use App\Models\Media;
use App\Models\Region;
use App\Services\ClassifiedService;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ClassifiedController.
 *
 * @property ClassifiedService $classifiedService
 * @property MediaService $mediaService
 */
final class ClassifiedController extends SiteController
{
    public function __construct(ClassifiedService $classifiedService, MediaService $mediaService)
    {
        parent::__construct();
        $this->data['categoryClassified'] = ClassifiedCategory::query()->where(['parent_id' => 0])->get();
        $this->data['regionCities'] = Region::query()->where([
            'level' => 2,
            'source_parent_id' => Region::SOURCE_PARENT_ID_VN
        ])->get();

        $this->classifiedService = $classifiedService;
        $this->mediaService = $mediaService;
    }

    public function index(Request $request, $slugCategory = '')
    {
        $items = $this->classifiedService->getClassifiedBySlugCategory($slugCategory, $request->all());

        $classifiedCategory = ClassifiedCategory::query()->where('slug', $slugCategory)->first();
        if (empty($classifiedCategory)) {
            $classifiedCategory = (object)[
                'title' => trans('layout_classified.category'),
            ];

            $this->classifiedService->buildCondition($request->all(), $condition, $sortBy, $sortType);
            $items = Classified::query()->where($condition)->orderBy(
                $sortBy,
                $sortType
            )->paginate(config('constant.PAGE_NUMBER'));
        }

        $data = [
            'classifiedCategory' => $classifiedCategory,
            'items' => $items,
            'title' => $classifiedCategory->title,
        ];

        return view($this->layout . 'classified.index', $this->render($data));
    }

    public function view(Request $request, $slugCategory = '', $slugClassified = '', $id = 0)
    {
        $classified = Classified::query()->where('id', $id)->where('status', Classified::STATUS_ACTIVE)->first();

        if (empty($classified)) {
            return redirect(base_url('404.html'));
        }

        Classified::query()->increment('views');

        $items = Classified::query()
            ->where('id', '!=', $id)
            ->where(['category_id' => $classified->category_id])->orderByDesc('id')->paginate($this->page_number);
        $classifiedCategory = ClassifiedCategory::query()->where('slug', $slugCategory)->first();

        $data = [
            'title' => $classified->title,
            'classified' => $classified,
            'classifiedCategory' => $classifiedCategory,
            'items' => $items,
        ];

        return view($this->layout . 'classified.view', $this->render($data));
    }

    public function myPost(Request $request)
    {
        $this->classifiedService->buildCondition($request->all(), $condition, $sortBy, $sortType);
        $condition['member_id'] = Auth::guard('web')->id();
        $items = Classified::query()->where($condition)->orderBy($sortBy, $sortType)
            ->paginate(config('constant.PAGE_NUMBER'));

        $data = [
            'items' => $items,
            'active_menu' => 'classified',
            'title' => trans('member.title_classified')
        ];

        return view('site.classified.my_classified', $this->render($data));
    }

    public function create()
    {
        $dropdownCategory = $this->classifiedService->dropdown();
        $data = [
            'active_menu' => 'classified',
            'title' => trans('member.title_classified_create'),
            'dropdownCategory' => $dropdownCategory
        ];

        return view('site.classified.create', $this->render($data));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $params['status'] = Classified::STATUS_WAITING_APPROVED;
            $params['source'] = Classified::SOURCE_INTERNAL;
            $params['member_id'] = Auth::guard('web')->id();
            $result = $this->classifiedService->create($params);

            if (empty($result['message'])) {
                // image
                if ($request->hasFile('file')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('file'),
                            'object_type' => Media::OBJECT_TYPE_CLASSIFIED,
                            'object_id' => $result['id'],
                        ]
                    );
                }

                // gallery
                if ($request->hasFile('file_multi')) {
                    foreach ($request->file('file_multi') as $file) {
                        $resultUpload = $this->mediaService->upload(
                            $file,
                            [
                                'object_type' => Media::OBJECT_TYPE_CLASSIFIED,
                                'object_id' => $result['id'],
                            ]
                        );
                        if (!empty($resultUpload['content']['id'])) {
                            ClassifiedImage::query()->create(
                                [
                                    'classified_id' => $result['id'],
                                    'image_id' => $resultUpload['content']['id'],
                                    'image_url' => $resultUpload['content']['file_name'],
                                    'creator_id' => Auth::guard('web')->id(),
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]
                            );
                        }
                    }
                }

                $request->session()->flash('success', trans('common.add.success'));

                return redirect(base_url('classified/my-post'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function destroy(Request $request, $id)
    {
        $myObject = Classified::query()->findOrFail($id);

        if (!empty($myObject->id)) {
            Classified::destroy($id);
        }

        $request->session()->flash('success', trans('common.delete.success'));

        return redirect(admin_url('classifieds'));
    }
}
