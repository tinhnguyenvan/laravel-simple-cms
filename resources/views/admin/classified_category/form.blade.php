@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ admin_url('classified_categories') }}{{ ($classified_category->id ?? 0) > 0 ?'/'.$classified_category->id: '' }}">
                @csrf
                @if (!empty($classified_category->id))
                    @method('PUT')
                @endif

                <input type="hidden" name="parent_id"
                       value="{{ old('parent_id', ($classified_category->parent_id ?? @request('parent_id', 0))) }}">

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
                        <div class="form-group">
                            <label class="col-form-label" for="title">{{ trans('classified.title') }}</label>
                            <div class="controls">
                                <input type="text"
                                       name="title"
                                       id="title"
                                       value="{{ old('title', $classified_category->title ?? '') }}"
                                       class="form-control @error('title') is-invalid @enderror"
                                />

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="slug">{{ trans('classified.slug') }}</label>
                            <div class="controls">
                                <input type="text" name="slug" id="slug"
                                       value="{{ old('slug', $classified_category->slug ?? '') }}" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-form-label"
                                   for="detail">{{ trans('classified.detail') }}</label>
                            <div class="controls">
                                <textarea class="form-control" id="detail" rows="5"
                                          name="detail">{{ old('detail', $classified_category->detail ?? '') }}</textarea>
                            </div>
                        </div>


                        @include('admin.element.form.input', ['name' => 'order_by', 'text' => trans('classified.order_by'), 'value' => $classified_category->order_by ?? ''])

                        @include('admin.element.form.image', ['name' => 'image_id', 'image_id' => $classified_category->image_id ?? '', 'image_url' => $classified_category->image_url ?? ''])

                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i>
                                {{ trans('common.save') }}
                            </button>
                        </div>
                    </div>
                </div>


                <!-- seo form -->
                @include('admin.element.form_seo', ['info' => $classified_category ?? ''])

            </form>

            @if (!empty($classified_category->id))
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="form-actions text-lg-right">
                            <form method="POST" action="{{ admin_url('classified_categories/'.$classified_category->id ) }}">
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
