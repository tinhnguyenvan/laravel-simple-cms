<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ConfigService;

/**
 * Class SiteController.
 */
class AdminController extends Controller
{
    public $page_number;
    protected $data;
    protected $theme = 'default';

    public function __construct()
    {
        $this->page_number = config('constant.PAGE_NUMBER');
        $config = ConfigService::getConfig();

        if (!empty($config['theme_active'])) {
            $this->theme = $config['theme_active'];
        }
        $manifest = @json_decode(file_get_contents(public_path('layout/' . $this->theme . '/manifest.json')), true);
        $this->data = [
            'manifest' => $manifest,
            'title' => env('APP_NAME'),
            'config' => $config,
            'theme' => $this->theme,
        ];
    }

    public function render($data)
    {
        $this->data['success'] = session('success');
        $this->data['error'] = session('error');

        return array_merge($this->data, $data);
    }
}
