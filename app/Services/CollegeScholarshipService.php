<?php

namespace App\Services;

use App\Models\CollegeScholarship;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class CollegeScholarshipService.
 *
 * @property CollegeScholarship $model
 */
class CollegeScholarshipService extends BaseService
{
    public function __construct(CollegeScholarship $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function beforeSave(&$formData = [], $isNews = false)
    {
        if (empty($formData['slug'])) {
            $formData['slug'] = $formData['name'];
        }

        $formData['slug'] = Str::slug($formData['slug']);

        if ($isNews) {
            $formData['creator_id'] = Auth::id() ?? 0;
            $countSlug = CollegeScholarship::query()->where('slug', $formData['slug'])->count();
            if ($countSlug > 0) {
                $formData['slug'] .= '-' . $countSlug;
            }
        } else {
            $formData['editor_id'] = Auth::id() ?? 0;
        }

        $myRegion = Region::query()->where('id', $formData['condition_country_id'])->first();
        $formData['condition_country_name'] = $myRegion->name;
    }

    /**
     * @param $params
     *
     * @return object|bool
     */
    public function create($params)
    {
        $this->beforeSave($params, true);
        $myObject = new CollegeScholarship($params);

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
        $this->beforeSave($params);
        $myObject = CollegeScholarship::query()->findOrFail($id);
        $result = $myObject->update($params);

        return $result;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function filter($params = [])
    {
        $active = [
            'status' => $params['status'] ?? 0,
        ];

        $form = [
            'status' => [
                'text' => trans('post.status'),
                'type' => 'select',
                'data' => CollegeScholarship::dropDownStatus(),
            ],
        ];

        return [
            'active' => $active,
            'form' => $form,
        ];
    }

    public function buildCondition($params = [], &$condition = [], &$sortBy = null, &$sortType = null)
    {
        $sortBy = 'id';
        $sortType = 'desc';

        if (!empty($params['status'])) {
            $condition['status'] = $params['status'];
        }

        if (!empty($params['search'])) {
            $search = [
                ['name', 'like', $params['search'] . '%'],
            ];

            if (empty($condition)) {
                $condition = $search;
            } else {
                $condition = array_merge($condition, $search);
            }
        }
    }
}
