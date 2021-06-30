@extends('admin.tool.qr_code.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data" action="{{ admin_url('tools/qr_code') }}">
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
                        <div class="nav-tabs-boxed">
                            @include('admin.element.form.input', ['name' => 'url', 'text' => 'QR Code', 'value' => ''])
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
            </form>
        </div>
    </div>
@endsection