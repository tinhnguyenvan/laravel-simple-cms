<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassifiedCategory;
use App\Models\Media;
use App\Services\ClassifiedCategoryService;
use App\Services\MediaService;
use Illuminate\Http\Request;

/**
 * Class ClassifiedCategoryController
 * @package App\Http\Controllers\Admin
 *
 * @property ClassifiedCategoryService $classifiedCategoryService
 * @property MediaService $mediaService
 */
class ClassifiedCategoryController extends AdminController
{
    public function __construct(ClassifiedCategoryService $classifiedCategoryService, MediaService $mediaService)
    {
        parent::__construct();
        $this->classifiedCategoryService = $classifiedCategoryService;
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $this->classifiedCategoryService->buildCondition($request->all(), $condition, $sortBy, $sortType);
        $condition['parent_id'] = 0;
        $items = ClassifiedCategory::query()->where($condition)->orderBy('order_by')->get();

        $data = [
            'items' => $items,
        ];

        return view('admin/classified_category/index', $this->render($data));
    }

    public function create()
    {
        $data = [
            'dropdownCategory' => $this->classifiedCategoryService->dropdown(),
            'classified_category' => new ClassifiedCategory(),
        ];

        return view('admin/classified_category/form', $this->render($data));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $result = $this->classifiedCategoryService->create($params);
            if (empty($result['message'])) {
                // image
                if ($request->hasFile('file')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('file'),
                            'object_type' => Media::OBJECT_TYPE_CLASSIFIED_CATEGORY,
                            'object_id' => $result['id'],
                        ]
                    );
                }

                $request->session()->flash('success', trans('common.add.success'));

                return redirect(admin_url('classified_categories'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function show($id)
    {
        return redirect(admin_url('classified_categories/' . $id . '/edit'), 302);
    }

    public function edit($id)
    {
        $data = [
            'dropdownCategory' => $this->classifiedCategoryService->dropdown(),
            'classified_category' => ClassifiedCategory::query()->findOrFail($id),
        ];

        return view('admin/classified_category/form', $this->render($data));
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            // remove image
            if (!empty($params['file_remove'])) {
                $params['image_id'] = 0;
                $params['image_url'] = '';
            }

            $result = $this->classifiedCategoryService->update($id, $params);

            if (empty($result['message'])) {
                // image
                if ($request->hasFile('file')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('file'),
                            'object_type' => Media::OBJECT_TYPE_CLASSIFIED_CATEGORY,
                            'object_id' => $id,
                        ]
                    );
                }

                $request->session()->flash('success', trans('common.edit.success'));

                return redirect(admin_url('classified_categories'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function destroy(Request $request, $id)
    {
        $myObject = ClassifiedCategory::query()->findOrFail($id);
        $countChild = ClassifiedCategory::query()->where(['parent_id' => $id])->count();
        if (!empty($myObject->id) && 0 == $countChild) {
            ClassifiedCategory::destroy($id);
        }

        if ($countChild > 0) {
            $request->session()->flash('error', trans('common.delete.exist.child'));
        } else {
            $request->session()->flash('success', trans('common.delete.success'));
        }

        return redirect(admin_url('classified_categories'));
    }
}
