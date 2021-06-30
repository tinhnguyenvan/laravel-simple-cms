@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data"
                  action="{{ admin_url('classifieds') }}{{ ($classified->id ?? 0) > 0 ?'/'.$classified->id: '' }}">
                @csrf
                @if (!empty($classified->id))
                    @method('PUT')
                @endif

                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-edit"></i> {{ trans('common.form') }}
                        <div class="card-header-actions">
                            <a class="btn btn-minimize" href="#" data-toggle="collapse" data-target="#collapseExample"
                               aria-expanded="true">
                                <i class="icon-arrow-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body collapse show" id="collapseExample">
                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#common" role="tab"
                                       aria-controls="common">
                                        <i class="fa fa-info-circle"></i> Information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#information" role="tab"
                                       aria-controls="information">
                                        <i class="fa fa-user"></i> {{ trans('classified.information') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#multi1" role="tab"
                                       aria-controls="multi1">
                                        <i class="fa fa-image"></i> Image
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#multi2" role="tab"
                                       aria-controls="multi2">
                                        <i class="icon-picture"></i> Gallery
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <!-- tab 1-->
                                <div class="tab-pane active" id="common" role="tabpanel">

                                    @include('admin.element.form.input', ['name' => 'title', 'text' => trans('classified.title'), 'value' => $classified->title ?? ''])

                                    <div class="form-group">
                                        <label class="col-form-label"
                                               for="title">{{ trans('classified.category_id') }}</label>
                                        <div class="controls">
                                            @include('admin.element.form.select', ['name' => 'category_id', 'data' => $dropdownCategory, 'selected' => old('category_id', $classified->category_id ?? 0)])
                                        </div>
                                    </div>

                                    @include('admin.element.form.input', ['name' => 'price', 'text' => trans('classified.price'), 'value' => $classified->price ?? 0, 'type' => 'number'])

                                    @include('admin.element.form.textarea', ['name' => 'detail', 'id' => 'editor1', 'text' => trans('classified.detail'), 'value' => $classified->detail ?? ''])

                                    <div class="form-group">
                                        <label class="col-form-label"
                                               for="status">{{ trans('classified.status') }}</label>
                                        <div class="controls">
                                            @foreach(\App\Models\Classified::STATUS_LIST as $status)
                                                @php($code = \App\Models\Classified::STATUS_LIST_CODE)
                                                @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('classified.status.'.$code[$status]), 'valueDefault' => $status, 'value' => $classified->status ?? 1])
                                            @endforeach
                                        </div>
                                    </div>


                                </div>

                                <!-- tab 2-->
                                <div class="tab-pane" id="multi1" role="tabpanel">
                                    @include('admin.element.form.image', ['name' => 'image_id', 'image_id' => $classified->image_id ?? '', 'image_url' => $classified->image_url ?? ''])
                                </div>

                                <!-- tab 3-->
                                <div class="tab-pane" id="multi2" role="tabpanel">
                                    @include('admin.element.form.image_multi', ['value' => $classified->images ?? []])
                                </div>

                                <!-- tab 4-->
                                <div class="tab-pane" id="information" role="tabpanel">
                                    @include('admin.element.form.input', ['name' => 'contact_fullname', 'text' => trans('classified.contact_fullname'), 'value' => $classified->contact_fullname ?? ''])
                                    @include('admin.element.form.input', ['name' => 'contact_phone', 'text' => trans('classified.contact_phone'), 'value' => $classified->contact_phone ?? ''])
                                    @include('admin.element.form.input', ['name' => 'contact_email', 'text' => trans('classified.contact_email'), 'value' => $classified->contact_email ?? ''])
                                    @include('admin.element.form.input', ['name' => 'contact_address', 'text' => trans('classified.contact_address'), 'value' => $classified->contact_address ?? ''])
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="form-actions" style="margin: 10px 0">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i>
                                {{ trans('common.save') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- seo form -->
                @include('admin.element.form_seo', ['info' => $classified ?? ''])

            </form>

            @if (!empty($classified->id))
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="form-actions text-lg-right">
                            <form method="post" action="{{ admin_url('classifieds/'.$classified->id ) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    <i class="fa fa-trash"></i>
                                    {{ trans('common.trash') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
