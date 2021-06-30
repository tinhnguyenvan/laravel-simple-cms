<?php
/**
 * @author: nguyentinh
 * @create: 12/28/19, 10:05 AM
 */

return [
    'MENU_ADMIN' => [
        [
            'title' => 'nav.menu_left.post',
            'url' => 'posts',
            'icon' => 'fa fa-newspaper-o',
            'child' => [
                [
                    'title' => 'nav.menu_left.post_category',
                    'url' => 'post_categories',
                    'icon' => 'fa fa-sitemap',
                ],
                [
                    'title' => 'nav.menu_left.post_list',
                    'url' => 'posts',
                    'icon' => 'icon-list',
                ],
                [
                    'title' => 'nav.menu_left.add',
                    'url' => 'posts/create',
                    'icon' => 'icon-plus',
                ],
                [
                    'title' => 'nav.menu_left.tags',
                    'url' => 'post_tags',
                    'icon' => 'icon-tag',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.product',
            'url' => '',
            'icon' => 'fa fa-cube',
            'child' => [
                [
                    'title' => 'nav.menu_left.product_category',
                    'url' => 'product_categories',
                    'icon' => 'fa fa-sitemap',
                ],
                [
                    'title' => 'nav.menu_left.product_list',
                    'url' => 'products',
                    'icon' => 'fa fa-list',
                ],
                [
                    'title' => 'nav.menu_left.add',
                    'url' => 'products/create',
                    'icon' => 'icon-plus',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.woocommerce',
            'url' => '',
            'icon' => 'fa fa-shopping-bag',
            'child' => [
                [
                    'title' => 'nav.menu_left.orders_list',
                    'url' => 'orders',
                    'icon' => 'fa fa-shopping-cart',
                ],
                [
                    'title' => 'nav.menu_left.orders_report',
                    'url' => 'orders/report',
                    'icon' => 'icon-chart',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.page',
            'url' => 'pages',
            'icon' => 'fa fa-copy',
            'child' => []
        ],
        [
            'title' => 'nav.menu_left.comment',
            'url' => 'comments',
            'icon' => 'fa fa-comment-o',
            'child' => []
        ],
        [
            'title' => 'nav.menu_left.media',
            'url' => 'medias',
            'icon' => 'fa fa-file-image-o',
            'child' => [
                [
                    'title' => 'nav.menu_left.media_list',
                    'url' => 'medias',
                    'icon' => 'icon-list',
                ],
                [
                    'title' => 'nav.menu_left.media_add',
                    'url' => 'medias/create',
                    'icon' => 'fa fa-cloud-upload',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.theme',
            'url' => 'themes',
            'icon' => 'fa fa-themeisle',
            'child' => [
                [
                    'title' => 'nav.menu_left.template',
                    'url' => 'themes',
                    'icon' => 'fa fa-themeisle',
                ],
                [
                    'title' => 'nav.menu_left.menu',
                    'url' => 'navs',
                    'icon' => 'fa fa-sitemap',
                ],
                [
                    'title' => 'nav.menu_left.ads',
                    'url' => 'ads',
                    'icon' => 'fa fa-image',
                ],
                [
                    'title' => 'nav.menu_left.theme_css',
                    'url' => 'themes/css',
                    'icon' => 'fa fa-code',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.setting',
            'url' => '',
            'icon' => 'fa fa-sliders',
            'child' => [
                [
                    'title' => 'nav.menu_left.configs',
                    'url' => 'configs',
                    'icon' => 'fa fa-cogs',
                ],
                [
                    'title' => 'nav.menu_left.plugins',
                    'url' => 'plugins',
                    'icon' => 'fa fa-unlock',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.user',
            'url' => '',
            'icon' => 'fa fa-users',
            'child' => [
                [
                    'title' => 'nav.menu_left.member_list',
                    'url' => 'members',
                    'icon' => 'icon-user',
                ], [
                    'title' => 'nav.menu_left.user_list',
                    'url' => 'users',
                    'icon' => 'icon-list',
                ],
                [
                    'title' => 'nav.menu_left.user_profile',
                    'url' => 'users/profile',
                    'icon' => 'icon-user',
                ],
                [
                    'title' => 'nav.menu_left.role',
                    'url' => 'roles/permission',
                    'icon' => 'icon-lock',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.contact',
            'url' => '',
            'icon' => 'fa fa-support',
            'child' => [
                [
                    'title' => 'nav.menu_left.contact_list',
                    'url' => 'contacts',
                    'icon' => 'icon-list',
                ],
                [
                    'title' => 'nav.menu_left.contact_update',
                    'url' => 'contact_forms/1/edit',
                    'icon' => 'icon-plus',
                ],
            ]
        ],
        [
            'title' => 'nav.menu_left.tool',
            'url' => '',
            'icon' => 'fa fa-code',
            'child' => [
                [
                    'title' => 'nav.menu_left.tool_qr_code',
                    'url' => 'tools/qr_code',
                    'icon' => 'fa fa-qrcode',
                ],        [
                    'title' => 'nav.menu_left.tool_short_link',
                    'url' => 'tools/short_link',
                    'icon' => 'fa fa-link',
                ],
            ]
        ],
    ],
    'DS' => '/',
    'LAYOUT_ADMIN' => 'admin.layouts.app',
    'LAYOUT' => 'product1',
    'PAGE_NUMBER' => 10,
    'MAX_FILE_UPLOAD' => 2,
    'MAX_FILE_SIZE_UPLOAD' => 1000, // 100px
    'URL_PREFIX_PRODUCT' => 'product',
    'URL_PREFIX_CLASSIFIED' => 'classified',
    'URL_PREFIX_POST' => 'post',
    'URL_PREFIX_COLLEGE' => 'college',
    'URL_PREFIX_TAG' => 'tag',
    'URL_PREFIX_PAGE' => 'page',
    'CONTACT_FORM_ID' => 1,
    'COOKIE_EXPIRED' => 2592000,
    'PRICE_UNIT' => 'vnđ',
    'VERSION' => 1,
];
