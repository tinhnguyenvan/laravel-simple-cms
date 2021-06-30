<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use App\Services\RegionService;
use Illuminate\Http\Request;

/**
 * Class RegionController
 * @package App\Http\Controllers\Admin
 *
 * @property RegionService $regionService
 */
class RegionController extends AdminController
{
    public function __construct(RegionService $regionService)
    {
        parent::__construct();
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        $this->regionService->buildCondition($request->all(), $condition, $sortBy, $sortType);
        $items = Region::query()->where($condition)->orderBy('order_by')->get();
        $level = $request->get('level');
        $parent_id = $request->get('parent_id');
        $data = [
            'parent_id' => $level == 1 ? 0 : $parent_id,
            'level' => $level,
            'level_back' => !empty($level) && $level > 2 ? $level - 1 : 1,
            'items' => $items,
        ];

        return view('admin/region/index', $this->render($data));
    }

    public function create()
    {
        $data = [
            'title' => trans('common.add') . ' ' . trans('nav.menu_left.regions'),
        ];

        return view('admin/region/form', $this->render($data));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $result = $this->regionService->create($params);
            if (empty($result['message'])) {
                $request->session()->flash('success', trans('common.add.success'));

                return redirect(admin_url('regions'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function show($id)
    {
        return redirect(admin_url('regions/' . $id . '/edit'), 302);
    }

    public function edit($id)
    {
        $data = [
            'region' => Region::query()->findOrFail($id),
        ];

        return view('admin/region/form', $this->render($data));
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();
        if (!empty($params['_token'])) {
            $result = $this->regionService->update($id, $params);

            if (empty($result['message'])) {
                $request->session()->flash('success', trans('common.edit.success'));

                return redirect(admin_url('regions'), 302);
            } else {
                $request->session()->flash('error', $result['message']);
            }
        }

        return back()->withInput();
    }

    public function destroy(Request $request, $id)
    {
        $myObject = Region::query()->findOrFail($id);
        $countChild = Region::query()->where(['parent_id' => $id])->count();
        if (!empty($myObject->id) && 0 == $countChild) {
            Region::destroy($id);
        }

        if ($countChild > 0) {
            $request->session()->flash('error', trans('common.delete.exist.child'));
        } else {
            $request->session()->flash('success', trans('common.delete.success'));
        }

        return redirect(admin_url('regions'));
    }
}
