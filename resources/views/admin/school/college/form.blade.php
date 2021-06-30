@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data"
                  action="{{ admin_url('colleges') }}{{ ($college->id ?? 0) > 0 ?'/'.$college->id: '' }}">
                @csrf
                @if (!empty($college->id))
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
                                        <i class="fa fa-info-circle"></i> {{ trans('college.information') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#information" role="tab"
                                       aria-controls="information">
                                        <i class="fa fa-user"></i> {{ trans('college.contact') }}
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

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#scholarships" role="tab"
                                       aria-controls="scholarships">
                                        <i class="fa fa-handshake-o"></i> {{ trans('nav.menu_left.scholarships') }}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- tab 1-->
                                <div class="tab-pane active" id="common" role="tabpanel">
                                    @include('admin.element.form.input', ['name' => 'name', 'text' => trans('college.name'), 'value' => $college->name ?? ''])
                                    @include('admin.element.form.textarea', ['name' => 'summary', 'id' => 'editor1', 'text' => trans('college.summary'), 'value' => $college->summary ?? ''])
                                    @include('admin.element.form.textarea', ['name' => 'detail_general', 'id' => 'editor2', 'text' => trans('college.detail_general'), 'value' => $college->detail_general ?? ''])
                                    @include('admin.element.form.textarea', ['name' => 'detail_applicant_eligibility' , 'id' => 'editor3','text' => trans('college.detail_applicant_eligibility'), 'value' => $college->detail_applicant_eligibility ?? ''])
                                    @include('admin.element.form.textarea', ['name' => 'detail_admission', 'id' => 'editor4', 'text' => trans('college.detail_admission'), 'value' => $college->detail_admission ?? ''])

                                    <div class="form-group">
                                        <label class="col-form-label" for="status">{{ trans('common.status') }}</label>
                                        <div class="controls">
                                            @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('college.status.active'), 'valueDefault' => \App\Models\College::STATUS_ACTIVE, 'value' => $post->status ?? 1])
                                            @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('college.status.disable'), 'valueDefault' => \App\Models\College::STATUS_DISABLE, 'value' => $post->status ?? 0])
                                        </div>
                                    </div>

                                </div>
                                
                                <!-- tab 2-->
                                <div class="tab-pane" id="information" role="tabpanel">
                                    @include('admin.element.form.input', ['name' => 'email', 'text' => trans('common.email'), 'value' => $college->email ?? ''])
                                    @include('admin.element.form.input', ['name' => 'phone', 'text' => trans('common.phone'), 'value' => $college->phone ?? ''])
                                    @include('admin.element.form.input', ['name' => 'website', 'text' => trans('common.website'), 'value' => $college->website ?? ''])
                                    @include('admin.element.form.input', ['name' => 'address', 'text' => trans('common.address'), 'value' => $college->address ?? ''])
                                    <div class="form-group">
                                        <label class="col-form-label"
                                               for="title">{{ trans('college.country_id') }}</label>
                                        <div class="controls">
                                            @include('admin.element.form.select', ['name' => 'country_id', 'data' => $dropdownCountry, 'selected' => old('country_id', $college->country_id ?? 0)])
                                        </div>
                                    </div>
                                </div>

                                <!-- tab 3-->
                                <div class="tab-pane" id="multi1" role="tabpanel">
                                    @include('admin.element.form.image', ['name' => 'image_id', 'text' => trans('college.image_id'), 'image_id' => $college->image_id ?? '', 'image_url' => $college->image_url ?? ''])
                                    @include('admin.element.form.cover', ['name' => 'cover_id', 'text' => trans('college.cover_id'), 'cover_id' => $college->cover_id ?? '', 'cover_url' => $college->cover_url ?? ''])
                                </div>

                                <!-- tab 4-->
                                <div class="tab-pane" id="multi2" role="tabpanel">
                                    @include('admin.element.form.image_multi', ['value' => $college->images ?? []])
                                </div>

                                <!-- scholarships -->
                                <div class="tab-pane" id="scholarships" role="tabpanel">
                                    <div class="input-group" style="margin: 10px auto">
                                        <input class="form-control" id="scholarship_id" name="search" style="width: 100%"
                                               placeholder="{{ trans('college.search.add.scholarship') }}"/>

                                    </div>
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
                @include('admin.element.form_seo', ['info' => $college ?? ''])

            </form>

            @if (!empty($college->id))
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="form-actions text-lg-right">
                            <form method="post" action="{{ admin_url('colleges/'.$college->id ) }}">
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
