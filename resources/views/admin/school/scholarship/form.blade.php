@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data"
                  action="{{ admin_url('college-scholarships') }}{{ ($collegeScholarship->id ?? 0) > 0 ?'/'.$collegeScholarship->id: '' }}">
                @csrf
                @if (!empty($collegeScholarship->id))
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
                        @include('admin.element.form.input', ['name' => 'name', 'text' => trans('college.scholarship.name'), 'value' => $collegeScholarship->name ?? ''])

                        <div class="form-group">
                            <label class="col-form-label"
                                   for="title">{{ trans('college.scholarship.condition_type') }}</label>
                            <div class="controls">
                                @include('admin.element.form.select', ['name' => 'condition_type', 'data' => $dropdownConditionType, 'selected' => old('condition_type', ($collegeScholarship->condition_type ?? 0))])
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label"
                                   for="title">{{ trans('college.scholarship.condition_country_id') }}</label>
                            <div class="controls">
                                @include('admin.element.form.select', ['name' => 'condition_country_id', 'data' => $dropdownCountry, 'selected' => old('condition_country_id', $college->condition_country_id ?? 0)])
                            </div>
                        </div>

                        @include('admin.element.form.input', ['name' => 'amount','type' => 'number', 'text' => trans('college.scholarship.amount'), 'value' => number_format($collegeScholarship->amount ?? 0)])
                        @include('admin.element.form.input', ['name' => 'expired_at', 'type' => 'date', 'text' => trans('college.scholarship.expired_at'), 'value' => $collegeScholarship->expired_at ?? ''])

                        @include('admin.element.form.textarea', ['name' => 'detail', 'id' => 'editor1', 'text' => trans('college.scholarship.detail'), 'value' => $collegeScholarship->detail ?? ''])

                        <div class="form-group">
                            <label class="col-form-label" for="status">{{ trans('post.status') }}</label>
                            <div class="controls">
                                @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('college.scholarship.status.active'), 'valueDefault' => \App\Models\Post::STATUS_ACTIVE, 'value' => $collegeScholarship->status ?? 1])
                                @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('college.scholarship.status.disable'), 'valueDefault' => \App\Models\Post::STATUS_DISABLE, 'value' => $collegeScholarship->status ?? 0])
                            </div>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i>
                                {{ trans('common.save') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- seo form -->
                @include('admin.element.form_seo', ['info' => $collegeScholarship ?? ''])

            </form>

            @if (!empty($collegeScholarship->id))
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="form-actions text-lg-right">
                            <form method="post" action="{{ admin_url('college-scholarships/'.$collegeScholarship->id ) }}">
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
