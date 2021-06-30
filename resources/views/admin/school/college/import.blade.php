@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data" action="{{ admin_url('colleges/import') }}">
                @csrf
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
                            <label class="col-form-label" for="">
                                File upload
                                <span class="text-sm-left text-warning">(File max size upload {{ @config('constant.MAX_FILE_SIZE_UPLOAD') }})</span>
                            </label>

                            <div class="controls">
                                <div class="input-group mb-3">
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="form-actions" style="margin: 10px 0">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-upload"></i>
                                {{ trans('common.btn.upload') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection