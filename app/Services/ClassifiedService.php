<?php
/**
 * @author: nguyentinh
 * @create: 11/20/19, 8:21 PM
 */

/**
 * @author: nguyentinh
 * @time: 10/29/19 4:05 PM
 */

namespace App\Services;

use App\Models\PostTag;
use App\Models\Classified;
use App\Models\ClassifiedCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class ProductService.
 *
 * @property Classified $model
 */
class ClassifiedService extends BaseService
{
    public function __construct(Classified $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function validator($params)
    {
        $error = [];

        $validator = Validator::make(
            $params,
            [
                'title' => 'required|min:5|max:255',
            ]
        );

        if ($validator->fails()) {
            static::convertErrorValidator($validator->errors()->toArray(), $error);
        }

        return $error;
    }

    public function beforeSave(&$formData = [], $isNews = false)
    {
        if (empty($formData['slug'])) {
            $formData['slug'] = $formData['title'];
        }

        $formData['slug'] = Str::slug($formData['slug']);

        if ($isNews) {
            $formData['creator_id'] = Auth::id() ?? 0;
            $countSlug = Classified::query()->where('slug', $formData['slug'])->count();
            if ($countSlug > 0) {
                $formData['slug'] .= '-' . $countSlug;
            }
        } else {
            $formData['editor_id'] = Auth::id() ?? 0;
        }

        $myCategory = ClassifiedCategory::query()->where('id', $formData['category_id'])->first();
        $formData['category_name'] = $myCategory->title;
    }

    /**
     * @param $params
     *
     * @return array|bool|object
     */
    public function create($params)
    {
        $validator = $this->validator($params);
        if (!empty($validator)) {
            return $this->responseValidator($validator);
        }

        $this->beforeSave($params, true);
        $myObject = new Classified($params);

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
        $validator = $this->validator($params);
        if (!empty($validator)) {
            return $this->responseValidator($validator);
        }

        $this->beforeSave($params);

        $myObject = Classified::query()->findOrFail($id);
        return $myObject->update($params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function filter($params = [])
    {
        $active = [
            'category_id' => $params['category_id'] ?? 0,
            'status' => $params['status'] ?? 0,
        ];

        $itemCategories = ClassifiedCategory::query()->orderByRaw(
            'CASE WHEN parent_id = 0 THEN id ELSE parent_id END, parent_id,id'
        )->get();
        $category = [];
        foreach ($itemCategories as $key => $value) {
            $category[$value->id] = create_line($value->level) . ' ' . $value->title;
        }
        $form = [
            'category_id' => [
                'text' => trans('post.category_id'),
                'type' => 'select',
                'data' => $category,
            ],
            'status' => [
                'text' => trans('post.status'),
                'type' => 'select',
                'data' => Classified::dropDownStatus(),
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

        if (!empty($params['category_id'])) {
            $condition['category_id'] = $params['category_id'];
        }

        if (!empty($params['search'])) {
            $search = [
                ['title', 'like', $params['search'] . '%'],
            ];

            if (empty($condition)) {
                $condition = $search;
            } else {
                $condition = array_merge($condition, $search);
            }
        }
    }

    /**
     * @return array
     */
    public function dropdown()
    {
        $data = ClassifiedCategory::query()->orderByRaw(
            'CASE WHEN parent_id = 0 THEN id ELSE parent_id END, parent_id,id'
        )->get();
        $html = [];
        if (!empty($data)) {
            foreach ($data as $key => $myCategory) {
                $html[$myCategory->id] = create_line($myCategory->level) . ' ' . $myCategory->title;
            }
        }

        return $html;
    }

    /**
     * @param $slugCategory
     * @param $paramRequest
     *
     * @return LengthAwarePaginator
     */
    public function getClassifiedBySlugCategory($slugCategory, $paramRequest)
    {
        $this->buildCondition($paramRequest, $condition, $sortBy, $sortType);

        return Classified::query()->where($condition)
            ->whereHas(
                'category',
                function (Builder $query) use ($slugCategory) {
                    $query->where('slug', $slugCategory)->orWhereHas(
                        'children',
                        function (Builder $query) use ($slugCategory) {
                            $query->where('slug', $slugCategory);
                        }
                    );
                }
            )->with('category.children')->orderBy($sortBy, $sortType)->paginate(config('constant.PAGE_NUMBER'));
    }
}
