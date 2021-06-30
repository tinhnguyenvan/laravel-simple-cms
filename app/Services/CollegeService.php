<?php

namespace App\Services;

use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\College;

/**
 * Class CollegeService.
 *
 * @property College $model
 */
class CollegeService extends BaseService
{
    public function __construct(College $model)
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
            $countSlug = College::query()->where('slug', $formData['slug'])->count();
            if ($countSlug > 0) {
                $formData['slug'] .= '-' . $countSlug;
            }
        } else {
            $formData['editor_id'] = Auth::id() ?? 0;
        }

        $myRegion = Region::query()->where('id', $formData['country_id'])->first();
        $formData['country_name'] = $myRegion->name;
    }

    /**
     * @param $params
     *
     * @return object|bool
     */
    public function create($params)
    {
        $this->beforeSave($params, true);
        $myObject = new College($params);

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
        $myObject = College::query()->findOrFail($id);
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
                'data' => College::dropDownStatus(),
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
