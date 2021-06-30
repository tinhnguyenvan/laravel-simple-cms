<?php

namespace App\Http\Controllers\Admin;

use App\Models\CollegeImage;
use App\Models\Media;
use App\Services\CollegeService;
use App\Services\MediaService;
use App\Services\RegionService;
use Illuminate\Http\Request;
use App\Models\College;
use Illuminate\Support\Facades\Auth;

/**
 * Class CollegeController
 *
 * @property CollegeService $collegeService
 * @property MediaService $mediaService
 * @property RegionService $regionService
 */
class CollegeController extends AdminController
{
    public function __construct(
        CollegeService $collegeService,
        MediaService $mediaService,
        RegionService $regionService
    ) {
        parent::__construct();
        $this->collegeService = $collegeService;
        $this->mediaService = $mediaService;
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        $this->collegeService->buildCondition($request->all(), $condition, $sortBy, $sortType);
        $items = College::query()->where($condition)->orderBy($sortBy, $sortType)->paginate($this->page_number);

        $filter = $this->collegeService->filter($request->all());
        $data = [
            'title' => trans('common.list') . ' ' . trans('nav.menu_left.colleges'),
            'filter' => $filter,
            'items' => $items,
        ];
        return view('admin.school.college.list', $this->render($data));
    }

    public function disabled(Request $request)
    {
        $params = $request->only('id');
        $college = College::query()->findOrFail($params['id']);

        if (!empty($college->id) && $college->status == College::STATUS_ACTIVE) {
            $college->status = College::STATUS_DISABLE;
            $college->save();
            $request->session()->flash('success', trans('common.edit.success'));
        } else {
            $request->session()->flash('error', trans('common.edit.error'));
        }

        return redirect(admin_url('colleges'), 302);
    }

    public function enabled(Request $request)
    {
        $params = $request->only('id');
        $college = College::query()->findOrFail($params['id']);

        if (!empty($college->id) && $college->status == College::STATUS_DISABLE) {
            $college->status = College::STATUS_ACTIVE;
            $college->save();
            $request->session()->flash('success', trans('common.edit.success'));
        } else {
            $request->session()->flash('error', trans('common.edit.error'));
        }

        return redirect(admin_url('colleges'), 302);
    }

    public function import()
    {
        $data = [
            'title' => trans('common.button.import_excel'),
        ];

        return view('admin.school.college.import', $this->render($data));
    }

    public function importHandle(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            // todo some thing
            $result['message'] = 'Import error';
            if (empty($result['message'])) {
                $request->session()->flash('success', trans('common.add.success'));

                return redirect(admin_url('colleges/import'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function create()
    {
        $data = [
            'title' => trans('common.add') . ' ' . trans('nav.menu_left.colleges'),
            'college' => new College(),
            'dropdownCountry' => $this->regionService->dropdownCountry(),
        ];

        return view('admin.school.college.form', $this->render($data));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $result = $this->collegeService->create($params);
            if (empty($result['message'])) {
                // image
                if ($request->hasFile('file')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('file'),
                            'object_type' => Media::OBJECT_TYPE_SCHOOL,
                            'object_id' => $result['id'],
                        ]
                    );
                }

                // cover
                if ($request->hasFile('cover')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('cover'),
                            'object_type' => Media::OBJECT_TYPE_SCHOOL,
                            'object_id' => $result['id'],
                        ],
                        'cover'
                    );
                }

                // gallery
                if ($request->hasFile('file_multi')) {
                    foreach ($request->file('file_multi') as $file) {
                        $resultUpload = $this->mediaService->upload(
                            $file,
                            [
                                'object_type' => Media::OBJECT_TYPE_SCHOOL,
                                'object_id' => $result['id'],
                            ]
                        );
                        if (!empty($resultUpload['content']['id'])) {
                            CollegeImage::query()->create(
                                [
                                    'college_id' => $result['id'],
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

                return redirect(admin_url('colleges'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function show($id)
    {
        return redirect(admin_url('colleges/' . $id . '/edit'), 302);
    }

    public function edit($id)
    {
        $data = [
            'title' => trans('common.edit') . ' ' . trans('nav.menu_left.colleges'),
            'college' => College::query()->findOrFail($id),
            'dropdownCountry' => $this->regionService->dropdownCountry(),
        ];

        return view('admin.school.college.form', $this->render($data));
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

            // remove cover_remove
            if (!empty($params['cover_remove'])) {
                $params['cover_id'] = 0;
                $params['cover_url'] = '';
            }

            $result = $this->collegeService->update($id, $params);

            if (empty($result['message'])) {
                // image
                if ($request->hasFile('file')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('file'),
                            'object_type' => Media::OBJECT_TYPE_SCHOOL,
                            'object_id' => $id,
                        ]
                    );
                }

                // cover
                if ($request->hasFile('cover')) {
                    $this->mediaService->uploadModule(
                        [
                            'file' => $request->file('cover'),
                            'object_type' => Media::OBJECT_TYPE_SCHOOL,
                            'object_id' => $id,
                        ],
                        'cover'
                    );
                }

                // gallery
                if ($request->hasFile('file_multi')) {
                    foreach ($request->file('file_multi') as $file) {
                        $resultUpload = $this->mediaService->upload(
                            $file,
                            [
                                'object_type' => Media::OBJECT_TYPE_SCHOOL,
                                'object_id' => $id,
                            ]
                        );
                        if (!empty($resultUpload['content']['id'])) {
                            CollegeImage::query()->create(
                                [
                                    'college_id' => $id,
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
                    CollegeImage::query()->whereIn('id', $params['file_multi_remove'])->delete();
                }

                $request->session()->flash('success', trans('common.edit.success'));

                return redirect(admin_url('colleges'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }
}
