<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>ZUR</b>VIZ',
    'logo_img' => 'vendor/adminlte/dist/img/logo2.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Zurviz',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        /*[
            'text' => 'search',
            'search' => true,
            'topnav' => true,
        ],*/
        /*[
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],*/
        /*[
            'text'        => 'pages',
            'url'         => 'admin/pages',
            'icon'        => 'far fa-fw fa-file',
            'label'       => 4,
            'label_color' => 'success',
        ],*/
        /*['header' => 'account_settings'],*/
        /*[
            'text' => 'profile',
            'url'  => 'admin/settings',
            'icon' => 'fas fa-fw fa-user',
        ],*/
        [
            'text' => 'Home',
            'url'  => 'admin',
            'icon' => 'fas fa-home',
            'label_color' => 'success',
        ],
        [
            'text' => 'Perfil',
            'url'  => 'admin/profile',
            'icon' => 'fas fa-user',
            'label_color' => 'success',
        ],
        [
            'text' => 'Usuarios',
            'url'  => 'admin/users',
            'icon' => 'fas fa-users',
            'label_color' => 'success',
        ],
        [
            'text' => 'Notificaciones',
            'url'  => 'admin/notifications',
            'icon' => 'fas fa-bell',
            'label_color' => 'success',
        ],
        [
            'text' => 'Planes del sitio',
            'url'  => 'admin/plans',
            'icon' => 'fas fa-book',
            'label_color' => 'success',
        ],
        [
            'text' => 'Actividades',
            'icon' => 'fas fa-users',
            'submenu' => [
                [
                    'text' => 'Reuniones',
                    'url'  => 'admin/meetings',
                    'icon' => 'fa fa-address-book',
                ],
                [
                    'text' => 'Clases',
                    'url'  => 'admin/cclasses',
                    'icon' => 'fa fa-address-book',
                ],
                [
                    'text' => 'Cursos',
                    'url'  => 'admin/courses',
                    'icon' => 'fa fa-address-book',
                ],                
            ],
        ],
        [
            'text' => 'Configuración',
            'icon' => 'fas fa-cog',
            'label_color' => 'success',
            'submenu' => [
                [
                    'text' => 'Temas',
                    'url'  => 'admin/themes',
                    'icon' => 'fas fa-bars',
                ],
                [
                    'text' => 'Sub temas',
                    'url'  => 'admin/subtopics',
                    'icon' => 'fas fa-align-center',
                ],
                [
                    'text' => 'Paises',
                    'url'  => 'admin/countries',
                    'icon' => 'fas fa-flag',
                    'label_color' => 'success',
                ],
                [
                    'text' => 'Tipos de documento',
                    'url'  => 'admin/documents',
                    'icon' => 'fas fa-file',
                ],
                [
                    'text' => 'Documentos de Cuenta',
                    'url'  => 'admin/document_accounts',
                    'icon' => 'far fa-file-alt',
                ],
                
                [
                    'text' => 'Instituciones',
                    'url'  => 'admin/institutions',
                    'icon' => 'fas fa-university',
                ],
                [
                    'text' => 'Intereses',
                    'url'  => 'admin/interests',
                    'icon' => 'fas fa-fw fa-user',
                ],
                [
                    'text' => 'Metodos de Pago',
                    'url'  => 'admin/payment_methods',
                    'icon' => 'fas fa-credit-card',
                ],
                [
                    'text' => 'Pasarela de pagos',
                    'url'  => 'admin/paymentgateway',
                    'icon' => 'fas fa-id-card',
                ],
                [
                    'text' => 'Redes Sociales',
                    'url'  => 'admin/social_networks',
                    'icon' => 'fa fa-location-arrow',
                ],
            ],
        ],

        [
            'text' => 'Paginas estáticas',
            'url'  => '#',
            'icon' => 'fas fa-pager',
            'submenu' => [
                [
                    'text' => 'Redes sociales del sitio',
                    'url'  => 'admin/social_networks_media',
                    'icon' => 'fab fa-facebook',
                ],
                [
                    'text' => 'Preguntas Frecuentes',
                    'url'  => 'admin/questions',
                    'icon' => 'fa fa-question',
                ],
                [
                    'text' => 'Categoria Información',
                    'url'  => 'admin/categoryinformation',
                    'icon' => 'fas fa-info-circle',
                ],
            ]
        ],
        [
            'text' => 'Banners',
            'url'  => '#',
            'icon' => 'fas fa-ad',
            'submenu' => [
                [
                    'text' => 'Anuncios',
                    'url'  => 'admin/advertisement',
                    'icon' => 'fas fa-book',
                ],
                [
                    'text' => 'Precios de los anuncios',
                    'url'  => 'admin/pricesadvertisements',
                    'icon' => 'fas fa-tags',
                ],
                [
                    'text' => 'Rutas',
                    'url'  => 'admin/paths',
                    'icon' => 'fas fa-vector-square',
                ]
            ]
        ],
        [
            'text' => 'Retiros',
            'url'  => '#',
            'icon' => 'fas fa-fw fa-book',
            'submenu' => [
                [
                    'text' => 'Politicas de retiro',
                    'url'  => 'admin/withdrawalpolicies',
                    'icon' => 'fas fa-fw fa-book',
                ],
                [
                    'text' => 'Retiros realizados',
                    'url'  => 'admin/withdrawal_requests',
                    'icon' => 'fas fa-fw fa-book',
                ],
            ],
        ],
        [
            'text' => 'Reportes',
            'icon' => 'fas fa-fw fa-credit-card',
            'submenu' => [
                [
                    'text' => 'Ingresos',
                    'icon' => 'fas fa-fw fa-credit-card',
                    'submenu' => [
                        [
                            'text' => 'Por instructor',
                            'url'  => 'admin/incomeinstructor',
                            'icon' => 'fas fa-fw fa-credit-card',
                        ],
                        [
                            'text' => 'Por reunion',
                            'url'  => 'admin/incomemeeting',
                            'icon' => 'fas fa-fw fa-credit-card',
                        ],
                        [
                            'text' => 'Por curso',
                            'url'  => 'admin/incomecourse',
                            'icon' => 'fas fa-fw fa-credit-card',
                        ],
                        [
                            'text' => 'Por clase',
                            'url'  => 'admin/incomeclass',
                            'icon' => 'fas fa-fw fa-credit-card',
                        ],
                    ],
                ],
                [
                    'text' => 'Pagos realizados',
                    'icon' => 'fas fa-users',
                    'submenu' => [
                        [
                            'text' => 'Por instructor',
                            'url'  => 'admin/paymentinstructor',
                            'icon' => 'fas fa-fw fa-credit-card',
                        ],
                        [
                            'text' => 'Por periodo',
                            'url'  => 'admin/paymentperiod',
                            'icon' => 'fas fa-fw fa-credit-card',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Centro de ayuda',
            'url'  => 'admin/help_desks',
            'icon' => 'fas fa-hands-helping',
        ],
        [
            'text' => 'Usuarios reportados',
            'url'  => 'admin/user_report',
            'icon' => 'fas fa-users',
        ],

        /* pricesadvertisements */
        /* advertisement */
        /*[
            'text'    => 'multilevel',
            'icon'    => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
                [
                    'text'    => 'level_one',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ],*/
        /*['header' => 'labels'],
        [
            'text'       => 'important',
            'icon_color' => 'red',
            'url'        => '#',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
            'url'        => '#',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'cyan',
            'url'        => '#',
        ],*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
