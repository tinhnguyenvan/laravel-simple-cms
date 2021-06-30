@extends('admin.layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ trans('common.list') }}

            <div class="card-header-actions">
                <a class="btn btn-sm btn-primary" href="{{ admin_url('college-scholarships/create') }}">
                    <small>
                        <i class="fa fa-plus"></i>
                        {{trans('common.button.add')}}
                    </small>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('admin.element.filter')

            <table class="table table-responsive-sm table-bordered">
                <thead>
                <tr>
                    <th>{{ trans('college.scholarship.name') }}</th>
                    <th>{{ trans('college.scholarship.condition_country_name') }}</th>
                    <th>{{ trans('college.scholarship.condition_type') }}</th>
                    <th>{{ trans('college.scholarship.amount') }}</th>
                    <th style="width: 150px">{{ trans('common.updated_at') }}</th>
                    <th style="width: 200px"></th>
                </tr>
                </thead>
                <tbody>
                @if (!empty($items) && $items->count() > 0)
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <a href="{{ admin_url('college-scholarships/'.$item->id.'/edit') }}">
                                    {{ $item->name }}
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>{{ $item->condition_country_name }}</td>
                            <td>{{ $item->condition_type }}</td>
                            <td>{{ number_format($item->amount) }}</td>
                            <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <button class="btn btn-{{ $item->status_color }} btn-sm">
                                    <i class="fa fa-check-circle-o"></i>
                                    {{ $item->status_text }}
                                </button>
                            </td>
                        </tr>
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

            @include('admin.element.pagination')
        </div>
    </div>
@endsection
