@extends('site.layout.member')
@section('content')
    <div class="content-panel">
        <ol class="breadcrumb">
            <li><a href="{{ base_url() }}"><i class="fa fa-home"></i> {{ trans('common.home') }}</a></li>
            <li class="active">{{ $title }}</li>
        </ol>
        <h3 class="fieldset-title">{{ $title }}</h3>
        <div class="row" style="margin: 10px 0">
            <div class="col-lg-12">
                <div class="text-right">
                    <a href="{{ base_url('classified/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil"></i> {{ trans('common.add') }}
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-responsive-sm table-bordered">
            <thead>
            <tr>
                <th style="width: 100px">Image</th>
                <th>{{ trans('common.title') }}</th>
                <th>{{ trans('common.category') }}</th>
                <th>{{ trans('common.cart.price') }}</th>
                <th>{{ trans('common.created_at') }}</th>
                <th class="th-status text-center" style="width: 200px">{{ trans('common.status') }}</th>
            </tr>
            </thead>
            <tbody>
            @if (!empty($items))
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center">
                            @if($item->image_url)
                                <img src="{{ asset('storage'.$item->image_url) }}" class="img-table img-thumbnail"
                                     alt="{{ $item->title }}"/>
                            @endif
                        </td>
                        <td>
                            <a href="{{ $item->link }}" target="_blank">
                                {{ $item->title }}
                            </a>

                            <label class="btn btn-xs btn-{{ $item->status_color }} btn-sm">
                                <i class="fa fa-check-circle-o"></i>
                                {{ $item->status_text }}
                            </label>
                        </td>
                        <td>
                            {{ $item->category_name }}
                        </td>
                        <td data-price="{{ $item->price }}">
                            {{ $item->price_format }}
                        </td>
                        <td>
                            {{ $item->created_at->format('d/m/Y H:s') }}
                        </td>

                        <td class="text-center">
                            <a class="btn btn-xs btn-primary" href=""><i class="fa fa-pencil"></i> </a>
                            <a class="btn btn-xs btn-danger" href=""><i class="fa fa-trash"></i> </a>
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
        </table>
    </div>
@endsection