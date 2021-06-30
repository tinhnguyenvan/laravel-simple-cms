@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ trans('common.list') }}

            <div class="card-header-actions">
                <a class="btn btn-sm btn-primary" href="{{ admin_url('classified_categories/create') }}">
                    <small>
                        <i class="fa fa-plus"></i>
                        {{trans('common.button.add')}}
                    </small>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('admin.element.filter')
            <table id="simple-tree-table" class="table table-responsive-sm table-bordered">
                <thead>
                <tr>
                    <th>{{ trans('classified.title') }}</th>
                    <th>{{ trans('classified.slug') }}</th>
                    <th class="text-center">{{ trans('classified.image_url') }}</th>
                    <th>{{ trans('classified.total_usage') }}</th>
                    <th>{{ trans('classified.created_at') }}</th>
                    <th style="width: 220px;"></th>
                </tr>
                </thead>
                <tbody>
                @if ($items->count() > 0)
                    @foreach ($items as $item)
                        @include('admin.classified_category.item', compact('item'))
                        @php($itemSub = \App\Models\ClassifiedCategory::query()->where(['parent_id' => $item->id])->orderBy('order_by')->get())
                        @if ($itemSub->count() > 0)
                            @foreach ($itemSub as $item)
                                @include('admin.classified_category.item', compact('item'))
                                @php($itemSub2 = \App\Models\ClassifiedCategory::query()->where(['parent_id' => $item->id])->orderBy('order_by')->get())
                                @if ($itemSub2->count() > 0)
                                    @foreach ($itemSub2 as $item)
                                        @include('admin.classified_category.item', compact('item'))
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            {{ trans('common.data_empty') }}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
