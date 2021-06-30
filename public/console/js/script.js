/*
 * @author: nguyentinh
 * @create: 11/18/19, 11:00 AM
 */

$(document).ready(function () {
    initializeMyPlugin();

    $(document).pjax('a:not(a[target="_blank"],a[target="_top"])', '#pjax-container');

    $(document).on('pjax:end', function () {
        initializeMyPlugin();
    });

    function initializeMyPlugin() {
        // initialize plugins
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * set menu sidebar-minimizer
         */
        let sidebar_minimizer = $.cookie('sidebar_minimizer');

        if (parseInt(sidebar_minimizer) === 1) {
            $('body').addClass('brand-minimized sidebar-minimized');
            $('.sidebar-nav').removeClass('ps ps--active-y');
        } else {
            $('body').removeClass('brand-minimized sidebar-minimized');
            $('.sidebar-nav').addClass('ps ps--active-y');
        }

        $('.sidebar-minimizer').on('click', function () {
            if (parseInt(sidebar_minimizer) === 1) {
                sidebar_minimizer = 0;
            } else {
                sidebar_minimizer = 1;
            }

            $.cookie('sidebar_minimizer', sidebar_minimizer, {expires: 365, path: '/'});
        });

        if (jQuery('#editor1').length > 0) {
            CKEDITOR.replace('editor1', {
                filebrowserUploadUrl: configs.filebrowserUploadUrl,
                filebrowserUploadMethod: 'form'
            });
        }
        if (jQuery('#editor2').length > 0) {
            CKEDITOR.replace('editor2', {
                filebrowserUploadUrl: configs.filebrowserUploadUrl,
                filebrowserUploadMethod: 'form'
            });
        }
        if (jQuery('#editor3').length > 0) {
            CKEDITOR.replace('editor3', {
                filebrowserUploadUrl: configs.filebrowserUploadUrl,
                filebrowserUploadMethod: 'form'
            });
        }
        if (jQuery('#editor4').length > 0) {
            CKEDITOR.replace('editor4', {
                filebrowserUploadUrl: configs.filebrowserUploadUrl,
                filebrowserUploadMethod: 'form'
            });
        }

        /**
         * js table tree item
         */
        if ($('#simple-tree-table').length > 0) {
            let data_opened = $('#simple-tree-table').attr('data-opened');
            let opened = 'all';
            if (data_opened === 'closed') {
                opened = 'closed';
            }

            $('#simple-tree-table').simpleTreeTable({
                opened: opened,
                iconPosition: ':first',
                iconTemplate: '<span />'
            });
        }

        /**
         * check all for all list data
         */
        if ($('#check_all').length > 0) {
            $('#check_all').on('click', function () {
                $('.check_id').prop('checked', $(this).prop('checked'));
                displayAction('.check_id');
            });

            $('.check_id').change(function () {
                displayAction('.check_id');
            });
        }


        /**
         * check all for all list data
         */
        if ($('#product_id').length > 0) {
            let options = {
                url: function (keyword) {
                    return configs.base_url + '/api/products?keyword=' + keyword
                },
                getValue: "title",
                listLocation: "data",
                list: {
                    onClickEvent: function () {
                        let item = $("#product_id").getSelectedItemData();
                        createItemOrder(item);
                    }
                }
            };

            $("#product_id").easyAutocomplete(options);
        }


        /**
         * check all for all list data
         */
        if ($('.clipboard').length > 0) {
            let clipboard = new ClipboardJS('.clipboard');
            clipboard.on('success', function (e) {
                console.info('Action:', e.action);
                console.info('Text:', e.text);
                console.info('Trigger:', e.trigger);

                e.clearSelection();
            });

            clipboard.on('error', function (e) {
                console.error('Action:', e.action);
                console.error('Trigger:', e.trigger);
            });
        }

        /**
         * check all for all list data
         */
        if ($('.tagsinput').length > 0) {
            $('.tagsinput').tagsinput('refresh');
        }

        $('[data-toggle="tooltip"]').tooltip();

    }
});

