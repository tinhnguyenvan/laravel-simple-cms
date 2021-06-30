<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ $title ?? 'Admin' }}</title>

    <link href="{{ asset("console/vendor/vendor.css") }}" rel="stylesheet">
    <script type="text/javascript">
      let configs = {
        'base_url': '{{ base_url() }}',
        'admin_url': '{{ base_url('admin') }}',
        'MAX_FILE_UPLOAD': '{{ @config('constant.MAX_FILE_UPLOAD') }}',
        'filebrowserUploadUrl': '{{ admin_url('ckeditor/upload?_token='. csrf_token()) }}'
      };
    </script>

    <script src="{{ asset("console/js/popper.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/jquery.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/jquery.easy-autocomplete.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/bootstrap-tagsinput.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/jquery-simple-tree-table.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/pace.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/perfect-scrollbar.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/plugin/highcharts/highcharts.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/plugin/highcharts/exporting.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/plugin/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/coreui.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/jquery.pjax.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/function.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/clipboard.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/jquery.cookie.js") }}" type="text/javascript"></script>
    <script src="{{ asset("console/js/script.js") }}" type="text/javascript"></script>
</head>
