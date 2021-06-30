<?php

namespace App\Http\Controllers\Site;

use App\Models\College;
use App\Models\CollegeScholarship;
use App\Services\CollegeService;
use Illuminate\Http\Request;

/**
 * Class CollegeController
 * @package App\Http\Controllers\Site
 *
 * @property CollegeService $collegeService
 */
class CollegeController extends SiteController
{
    public function __construct(CollegeService $collegeService)
    {
        parent::__construct();
        $this->collegeService = $collegeService;
    }

    public function index(Request $request, $slugCategory)
    {
        $items = College::query()
            ->where('status', College::STATUS_ACTIVE)
            ->orderByDesc('id')
            ->paginate(config('constant.PAGE_NUMBER'));

        $data = [
            'items' => $items,
            'title' => trans('common.list'),
        ];

        return view($this->layout . 'college.list', $this->render($data));
    }

    public function view(Request $request, $slug)
    {
        $college = College::query()->where('slug', $slug)->first();

        if (empty($college)) {
            return redirect(base_url('404.html'));
        }

        College::query()->increment('views');

        $items = College::query()->where('id', '!=', $college->id)->orderByDesc('id')->paginate($this->page_number);

        $data = [
            'title' => $college->title,
            'college' => $college,
            'items' => $items,
        ];

        return view($this->layout . 'college.view', $this->render($data));
    }

    public function scholarship(Request $request, $slugCategory)
    {
        $items = CollegeScholarship::query()
            ->where('status', CollegeScholarship::STATUS_ACTIVE)
            ->orderByDesc('id')
            ->paginate(config('constant.PAGE_NUMBER'));

        $data = [
            'items' => $items,
            'title' => trans('common.list'),
        ];

        return view($this->layout . 'college_scholarship.list', $this->render($data));
    }
}
