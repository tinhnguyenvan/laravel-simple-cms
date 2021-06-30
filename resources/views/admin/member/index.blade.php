@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ trans('common.list') }}

            <div class="card-header-actions">
                <a class="btn btn-sm btn-primary" target="_blank" href="{{ base_url('member/register') }}">
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
                    <th>{{ trans('member.fullname') }}</th>
                    <th>{{ trans('common.email') }}</th>
                    <th>{{ trans('common.phone') }}</th>
                    <th>{{ trans('member.source') }}</th>
                    <th>{{ trans('common.updated_at') }}</th>
                    <th style="width: 200px"></th>
                </tr>
                </thead>
                <tbody>
                @if ($items->count() > 0)
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->fullname }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                @if(!empty($item->socials))
                                    @foreach($item->socials as $social)
                                        <label style="margin-right: 5px" class="label label-{{ $social->provider_color }}">
                                            {{ $social->provider }}
                                        </label>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $item->updated_at }}</td>
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
                        <td colspan="4">
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
