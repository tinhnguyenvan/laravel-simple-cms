<?php

namespace App\Http\Controllers\Admin;

use App\Models\CollegeScholarship;
use App\Services\CollegeScholarshipService;
use App\Services\CollegeService;
use App\Services\MediaService;
use App\Services\RegionService;
use Illuminate\Http\Request;

/**
 * Class CollegeScholarshipController
 *
 * @property CollegeService $collegeService
 * @property MediaService $mediaService
 * @property RegionService $regionService
 * @property CollegeScholarshipService $collegeScholarshipService
 */
class CollegeScholarshipController extends AdminController
{
    public function __construct(
        CollegeScholarshipService $collegeScholarshipService,
        CollegeService $collegeService,
        MediaService $mediaService,
        RegionService $regionService
    ) {
        parent::__construct();
        $this->collegeScholarshipService = $collegeScholarshipService;
        $this->collegeService = $collegeService;
        $this->mediaService = $mediaService;
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        $this->collegeScholarshipService->buildCondition($request->all(), $condition, $sortBy, $sortType);
        $items = CollegeScholarship::query()->where($condition)->orderBy($sortBy, $sortType)->paginate($this->page_number);

        $filter = $this->collegeScholarshipService->filter($request->all());
        $data = [
            'title' => trans('common.edit') . ' ' . trans('nav.menu_left.scholarships'),
            'filter' => $filter,
            'items' => $items,
        ];
        return view('admin.school.scholarship.index', $this->render($data));
    }

    public function create()
    {
        $data = [
            'title' => trans('common.add') . ' ' . trans('nav.menu_left.colleges'),
            'collegeScholarship' => new CollegeScholarship(),
            'dropdownCountry' => $this->regionService->dropdownCountry(),
            'dropdownConditionType' => $this->regionService->dropdownCountry(),
        ];

        return view('admin.school.scholarship.form', $this->render($data));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $result = $this->collegeScholarshipService->create($params);
            if (empty($result['message'])) {
                $request->session()->flash('success', trans('common.add.success'));

                return redirect(admin_url('college-scholarships'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function show($id)
    {
        return redirect(admin_url('college-scholarships/' . $id . '/edit'), 302);
    }

    public function edit($id)
    {
        $data = [
            'title' => trans('common.edit') . ' ' . trans('nav.menu_left.colleges'),
            'collegeScholarship' => CollegeScholarship::query()->findOrFail($id),
            'dropdownCountry' => $this->regionService->dropdownCountry(),
            'dropdownConditionType' => $this->regionService->dropdownCountry(),
        ];

        return view('admin.school.scholarship.form', $this->render($data));
    }

    public function update($id, Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $result = $this->collegeScholarshipService->update($id, $params);

            if (empty($result['message'])) {
                $request->session()->flash('success', trans('common.edit.success'));

                return redirect(admin_url('college-scholarships'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }
}
