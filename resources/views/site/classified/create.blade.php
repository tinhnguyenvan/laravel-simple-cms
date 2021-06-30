@extends('site.layout.member')
@section('content')
    <div class="content-panel">
        <ol class="breadcrumb">
            <li><a href="{{ base_url() }}"><i class="fa fa-home"></i> {{ trans('common.home') }}</a></li>
            <li class="active">{{ $title }}</li>
        </ol>
        <h3 class="fieldset-title">{{ $title }}</h3>
        <div class="row">
            <div class="col-lg-8">
                <form method="post" enctype="multipart/form-data" action="{{ base_url('classified/create') }}">
                    @csrf
                    <h4><i class="fa fa-info-circle"></i> Information</h4>
                    <hr/>
                    <div class="classified-box-group-create">
                        <div class="form-group">
                            <label class="col-form-label"
                                   for="title">{{ trans('classified.category_name') }}</label>
                            <div class="controls">
                                @include('admin.element.form.select', ['name' => 'category_id', 'data' => $dropdownCategory, 'selected' => old('category_id', $classified->category_id ?? 0)])
                            </div>
                        </div>

                        @include('admin.element.form.input', ['name' => 'title', 'text' => trans('classified.title'), 'value' => $classified->title ?? ''])
                        @include('admin.element.form.input', ['name' => 'price', 'text' => trans('classified.price'), 'value' => $classified->price ?? 0, 'type' => 'number'])
                        @include('admin.element.form.textarea', ['name' => 'detail', 'rows' => 12, 'id' => 'detail', 'text' => trans('classified.detail'), 'value' => $classified->detail ?? ''])
                    </div>
                    <h4><i class="fa fa-user"></i> {{ trans('classified.information') }}</h4>
                    <hr/>
                    <div class="classified-box-group-create">
                        @include('admin.element.form.input', ['name' => 'contact_fullname', 'text' => trans('classified.contact_fullname'), 'value' => $classified->contact_fullname ?? ''])
                        @include('admin.element.form.input', ['name' => 'contact_phone', 'text' => trans('classified.contact_phone'), 'value' => $classified->contact_phone ?? ''])
                        @include('admin.element.form.input', ['name' => 'contact_email', 'text' => trans('classified.contact_email'), 'value' => $classified->contact_email ?? ''])
                        @include('admin.element.form.input', ['name' => 'contact_address', 'text' => trans('classified.contact_address'), 'value' => $classified->contact_address ?? ''])
                    </div>
                    <h4><i class="fa fa-image"></i> Image</h4>
                    <hr/>
                    <div class="classified-box-group-create">
                        @include('admin.element.form.image', ['name' => 'image_id', 'image_id' => $classified->image_id ?? '', 'image_url' => $classified->image_url ?? ''])
                    </div>
                    <h4><i class="fa fa-image"></i> Gallery</h4>
                    <hr/>
                    <div class="classified-box-group-create">
                        @include('admin.element.form.image_multi', ['value' => $classified->images ?? []])
                    </div>

                    <div class="loginbox-submit">
                        <input type="submit" class="btn btn-primary" value="{{ trans('layout_classified.button_add') }}">
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
            </div>
        </div>
    </div>
@endsection