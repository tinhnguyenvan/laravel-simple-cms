@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ trans('common.list') }}

            <div class="card-header-actions">
                <a class="btn btn-sm btn-primary" href="{{ admin_url('classifieds/create') }}">
                    <small>
                        <i class="fa fa-plus"></i>
                        {{trans('common.button.add')}}
                    </small>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('admin.element.filter')
            <form method="post" action="{{ admin_url('classifieds/destroy-multi') }}">
                @csrf
                @method('DELETE')
                <table class="table table-responsive-sm table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">
                            <input type="checkbox" name="check_all" id="check_all" value="1">
                        </th>
                        <th>{{ trans('classified.image_url') }}</th>
                        <th>{{ trans('classified.title') }}</th>
                        <th>{{ trans('classified.category_name') }}</th>
                        <th>{{ trans('classified.information') }}</th>
                        <th>{{ trans('classified.price_and_location') }}</th>
                        <th>{{ trans('classified.created_at') }}</th>
                        <th class="th-status">{{ trans('classified.status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($items))
                        @foreach ($items as $item)
                            <tr>
                                <td class="text-center">
                                    <input class="check_id" type="checkbox" name="ids[]" value="{{ $item->id }}">
                                </td>
                                <td class="text-center">
                                    @if($item->image_url)
                                        <img src="{{ asset('storage'.$item->image_url) }}"
                                             class="img-table img-thumbnail"/>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ admin_url('classifieds/'.$item->id.'/edit') }}">
                                        {{ $item->title }}
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    {{ $item->category_name }}
                                </td>
                                <td>
                                    <i class="icon-user"></i> {{ $item->contact_fullname}}<br/>
                                    <i class="icon-phone"></i> {{ $item->contact_phone }}<br/>
                                    <i class="icon-envelope"></i> {{ $item->contact_email }}<br/>
                                </td>
                                <td data-price="{{ $item->price }}">
                                    {{ $item->price_format }}
                                </td>
                                <td>
                                    {{ $item->created_at->format('d/m/Y H:s') }}
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

                    <tfoot>
                    <tr>
                        <td colspan="8">
                            @include('admin.element.button.delete_multi')
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </form>

            @include('admin.element.pagination')
        </div>
    </div>

@endsection
