@extends('admin.layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ trans('common.list') }}

            <div class="card-header-actions">
                <a class="btn btn-sm btn-primary" href="{{ admin_url('colleges/create') }}">
                    <small>
                        <i class="fa fa-plus"></i>
                        {{trans('common.button.add')}}
                    </small>
                </a>

                <a class="btn btn-sm btn-success" href="{{ admin_url('colleges/import') }}">
                    <small>
                        <i class="fa fa-file-excel-o"></i>
                        {{trans('common.button.import_excel')}}
                    </small>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('admin.element.filter')

            <table class="table table-responsive-sm table-bordered">
                <thead>
                <tr>
                    <th class="text-center">{{ trans('common.image_url') }}</th>
                    <th>{{ trans('college.name') }}</th>
                    <th>{{ trans('college.country_name') }}</th>
                    <th>{{ trans('common.phone') }}</th>
                    <th>{{ trans('common.updated_at') }}</th>
                    <th style="width: 100px"></th>
                </tr>
                </thead>
                <tbody>
                @if (!empty($items) && $items->count() > 0)
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-center">
                                @if($item->image_url)
                                    <img src="{{ asset('storage'.$item->image_url) }}"
                                         class="img-table img-thumbnail"/>
                                @endif
                            </td>
                            <td>
                                <a href="{{ admin_url('colleges/'.$item->id.'/edit') }}">
                                    {{ $item->name }}
                                    <i class="fa fa-edit"></i>
                                </a>
                                <label class="label label-{{ $item->status_color }} btn-sm">
                                    <i class="fa fa-check-circle-o"></i>
                                    {{ $item->status_text }}
                                </label>
                            </td>
                            <td>{{ $item->country_name }}</td>
                            <td>{{ $item->phone }}</td>

                            <td>{{ !empty($item->updated_at) ? $item->updated_at->format('d/m/Y H:s') : '--' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" style="margin: 0;">
                                        @if($item->status == \App\Models\College::STATUS_ACTIVE)
                                            <form method="post" action="{{ admin_url('colleges/disabled') }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" value="{{ $item->id }}" name="id">
                                                <button class="btn-default btn-none text-danger">
                                                    <i class="fa fa-ban text-danger"></i> {{ trans('common.btn.private') }}
                                                </button>
                                            </form>
                                        @endif

                                            @if($item->status == \App\Models\College::STATUS_DISABLE)
                                                <form method="post" action="{{ admin_url('colleges/enabled') }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="{{ $item->id }}" name="id">
                                                    <button class="btn-default btn-none text-primary">
                                                        <i class="fa fa-check text-primary"></i> {{ trans('common.btn.public') }}
                                                    </button>
                                                </form>
                                            @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
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