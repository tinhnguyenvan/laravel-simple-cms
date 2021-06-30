<?php

namespace App\Http\Controllers\Api;

use App\Models\College;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Class CollegeController
 *
 * @group College
 *
 * @package App\Http\Controllers\Api
 */
final class CollegeController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get list
     *
     * @bodyParam keyword. Example: title
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $params = $request->only('keyword');

        $object = College::query();

        if (!empty($params['keyword'])) {
            $object->where('title', 'like', $params['keyword'] . '%');
        }

        $column = ['id', 'name'];

        return $object->orderBy('id', 'desc')->select($column)->paginate(20);
    }

    /**
     * Create
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
    }

    /**
     * Display
     *
     * @param int $id
     *
     * @return void
     */
    public function show($id)
    {
    }

    /**
     * Update
     *
     * @param Request $request
     * @param int $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
    }
}
