<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classified;
use App\Models\ClassifiedImage;
use App\Models\Media;
use App\Services\ClassifiedCategoryService;
use App\Services\MediaService;
use App\Services\ClassifiedService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ClassifiedController
 * @package App\Http\Controllers\Admin
 *
 * @property MediaService $mediaService
 * @property ClassifiedCategoryService $classifiedCategoryService
 * @property ClassifiedService $classifiedService
 */
class ClassifiedController extends AdminController
{
    public function __construct(
        ClassifiedService $classifiedService,
        ClassifiedCategoryService $classifiedCategoryService,
        MediaService $mediaService
    ) {
        parent::__construct();

        $this->mediaService = $mediaService;
        $this->classifiedService = $classifiedService;
        $this->classifiedCategoryService = $classifiedCategoryService;
    }

    public function index(Request $request)
    {
        $this->classifiedService->buildCondition($request->all(), $condition, $sortBy, $sortType);
        $items = Classified::query()->where($condition)->orderBy($sortBy, $sortType)->paginate($this->page_number);

        $filter = $this->classifiedService->filter($request->all());

        $data = [
            'title' => trans('common.list') . ' ' . trans('nav.menu_left.classified'),
            'filter' => $filter,
            'items' => $items,
        ];

        return view('admin/classified.index', $this->render($data));
    }

    public function create()
    {
        $data = [
            'title' => trans('common.add') . ' ' . trans('nav.menu_left.classified'),
            'classified' => new Classified(),
            'dropdownCategory' => $this->classifiedService->dropdown(),
        ];

        return view('admin/classified.form', $this->render($data));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
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
                                    'creator_id' => Auth::id(),
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]
                            );
                        }
                    }
                }

                $request->session()->flash('success', trans('common.add.success'));

                return redirect(admin_url('classifieds'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function show($id)
    {
        return redirect(admin_url('classifieds/' . $id . '/edit'), 302);
    }

    public function edit($id)
    {
        $data = [
            'title' => trans('common.edit') . ' ' . trans('nav.menu_left.product'),
            'dropdownCategory' => $this->classifiedCategoryService->dropdown(),
            'classified' => Classified::query()->findOrFail($id),
        ];

        return view('admin/classified.form', $this->render($data));
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            // remove image
            if (!empty($params['file_remove'])) {
                $params['image_id'] = 0;
                $params['image_url'] = '';
            }

            $result = $this->classifiedService->update($id, $params);

            if (empty($result['message'])) {
                // image
                if ($request->hasFile('file')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('file'),
                            'object_type' => Media::OBJECT_TYPE_CLASSIFIED,
                            'object_id' => $id,
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
                                'object_id' => $id,
                            ]
                        );
                        if (!empty($resultUpload['content']['id'])) {
                            ClassifiedImage::query()->create(
                                [
                                    'classified_id' => $id,
                                    'image_id' => $resultUpload['content']['id'],
                                    'image_url' => $resultUpload['content']['file_name'],
                                    'creator_id' => Auth::id(),
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]
                            );
                        }
                    }
                }

                // remove gallery
                if (!empty($params['file_multi_remove'])) {
                    ClassifiedImage::query()->whereIn('id', $params['file_multi_remove'])->delete();
                }

                $request->session()->flash('success', trans('common.edit.success'));

                return redirect(admin_url('classifieds'), 302);
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyMulti(Request $request)
    {
        $params = $request->all();

        if (!empty($params['ids'])) {
            $items = Classified::query()->whereIn('id', $params['ids'])->get();
            foreach ($items as $item) {
                $item->delete();
            }
            $request->session()->flash('success', trans('common.delete.success'));
        } else {
            $request->session()->flash('error', trans('common.error_check_ids'));
        }

        return back();
    }
}
