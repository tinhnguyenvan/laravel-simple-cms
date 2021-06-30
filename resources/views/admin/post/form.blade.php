@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">

            <form method="post" enctype="multipart/form-data"
                  action="{{ admin_url('posts') }}{{ ($post->id ?? 0) > 0 ?'/'.$post->id: '' }}">
                @csrf
                @if (!empty($post->id))
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
                        @include('admin.element.form.input', ['name' => 'title', 'text' => trans('post.title'), 'value' => $post->title ?? ''])

                        <div class="form-group">
                            <label class="col-form-label" for="title">{{ trans('post.category_id') }}</label>
                            <div class="controls">
                                @include('admin.element.form.select', ['name' => 'category_id', 'data' => $dropdownCategory, 'selected' => old('category_id', ($post->category_id ?? 0))])
                            </div>
                        </div>

                        @include('admin.element.form.textarea', ['name' => 'summary', 'text' => trans('post.summary'), 'value' => $post->summary ?? ''])

                        <div class="form-group">
                            <label class="col-form-label" for="editor1">{{ trans('post.detail') }}</label>
                            <div class="controls">
                                <textarea class="form-control" id="editor1" name="detail">
                                    {{ old('detail',$post->detail??'') }}
                                </textarea>
                            </div>
                        </div>

                        @include('admin.element.form.image', ['name' => 'image_id', 'image_id' => $post->image_id ?? '', 'image_url' => $post->image_url ?? ''])
                        @include('admin.element.form.tags', ['name' => 'tags', 'text' => trans('common.tags'), 'value' => $post->tags ?? ''])

                        <div class="form-group">
                            <label class="col-form-label" for="status">{{ trans('post.status') }}</label>
                            <div class="controls">
                                @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('post.status.active'), 'valueDefault' => \App\Models\Post::STATUS_ACTIVE, 'value' => $post->status ?? 1])
                                @include('admin.element.form.radio', ['name' => 'status', 'text' => trans('post.status.disable'), 'valueDefault' => \App\Models\Post::STATUS_DISABLE, 'value' => $post->status ?? 0])
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
                @include('admin.element.form_seo', ['info' => $post ?? ''])

            </form>

            @if (!empty($post->id))
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="form-actions text-lg-right">
                            <form method="post" action="{{ admin_url('posts/'.$post->id ) }}">
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
