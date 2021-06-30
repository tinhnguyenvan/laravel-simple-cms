@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ trans('common.list') }}

            <div class="card-header-actions">
                <a class="btn btn-sm btn-primary" href="{{ admin_url('ads/create') }}">
                    <small>
                        <i class="fa fa-plus"></i>
                        {{trans('common.button.add')}}
                    </small>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('admin.element.filter')

            <form method="get" action="{{ admin_url('ads') }}">
                <table class="table table-responsive-sm table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('common.title') }}</th>
                        <th>{{ trans('common.position') }}</th>
                        <th>{{ trans('common.created_at') }}</th>
                        <th class="text-center">{{ trans('common.image_url') }}</th>
                        <th class="text-center">{{ trans('common.status') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if ($items->count() > 0)
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <a href="{{ admin_url('ads/'.$item->id.'/edit') }}">
                                        {{ $item->title }}
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    {{  $item->position }}
                                </td>

                                <td>
                                    {{ $item->created_at->format('d/m/Y H:s') }}
                                </td>
                                <td class="text-center">
                                    @if($item->image_url)
                                        <img src="{{ asset('storage'.$item->image_url) }}"
                                             class="img-table img-thumbnail"/>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <label class="btn btn-{{ $item->status_color }} btn-sm">
                                        <i class="fa fa-check-circle-o"></i>
                                        {{ $item->status_text }}
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">
                                {{ trans('common.data_empty') }}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </form>

            @include('admin.element.pagination')
        </div>
    </div>

@endsection
