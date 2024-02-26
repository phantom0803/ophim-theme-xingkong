<?php

namespace Ophim\ThemeXingKong;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;

class ThemeXingKongServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/xingkong')
        ], 'xingkong-assets');

        view()->composer('themes::themexingkong.*', function ($view) {
            $view->with('menu', \Ophim\Core\Models\Menu::getTree());
        });

        view()->composer(['themes::themexingkong.inc.right_bar'], function ($view) {
            $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
                $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
                $data = [];
                foreach ($lists as $list) {
                    if (trim($list)) {
                        $list = explode('|', $list);
                        [$label, $relation, $field, $val, $sortKey, $alg, $limit] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4]);
                        try {
                            $data[] = [
                                'label' => $label,
                                'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                                    $query->whereHas($relation, function ($rel) use ($field, $val) {
                                        $rel->where($field, $val);
                                    });
                                })
                                    ->when(!$relation, function ($query) use ($field, $val) {
                                        $query->where($field, $val);
                                    })
                                    ->orderBy($sortKey, $alg)
                                    ->limit($limit)
                                    ->get(),
                            ];
                        } catch (\Exception $e) {
                            # code
                        }
                    }
                }

                return $data;
            });
            $view->with('tops', $tops);
        });
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'xingkong' => [
                'name' => 'Theme XingKong',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-xingkong',
                'publishes' => ['xingkong-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommended movies limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 30,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 12,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|display_description|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_more_url|section_template(default|with_top)',
                        'value' => <<<EOT
                        Phim chiếu rạp mới||is_shown_in_theater|1|created_at|desc|12|/danh-sach/phim-chieu-rap|default
                        Phim bộ mới||type|series|updated_at|desc|10|/danh-sach/phim-bo|with_top
                        Phim lẻ mới||type|single|updated_at|desc|10|/danh-sach/phim-le|with_top
                        Phim hoạt hình mới|categories|slug|hoat-hinh|updated_at|desc|10|/the-loai/hoat-hinh|with_top
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => <<<EOT
                        Phim sắp chiếu||status|trailer|publish_year|desc|8
                        Top phim lẻ||type|single|view_week|desc|8
                        Top phim bộ||type|series|view_week|desc|8
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => '',
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <footer>
                            <div class="container">
                                <div class="row">
                                    <div class="stui-foot clearfix">
                                        <p class="text-center hidden-xs">
                                        <a class="fed-font-xiv" href="#" target="_blank">Textlink</a>
                                        <span class="fed-font-xiv"> - </span>
                                        <a class="fed-font-xiv" href="#" target="_blank">Textlink</a>
                                        <span class="fed-font-xiv fed-hide-xs"> - </span>
                                        <a class="fed-font-xiv fed-hide-xs" href="#" target="_blank">Textlink</a>
                                        <span class="fed-font-xiv fed-hide-xs"> - </span>
                                        <a class="fed-font-xiv fed-hide-xs" href="#" target="_blank">Textlink</a>
                                        <span class="fed-font-xiv fed-hide-xs"> - </span>
                                        <a class="fed-font-xiv fed-hide-xs" href="#" target="_blank">Textlink</a>
                                        <span class="fed-font-xiv fed-hide-xs"> - </span>
                                        <a class="fed-font-xiv fed-hide-xs" href="#" target="_blank">Textlink</a>
                                        <span class="fed-font-xiv fed-hide-xs"> - </span>
                                        <a class="fed-font-xiv fed-hide-xs" href="#" target="_blank">Textlink</a>
                                        </p>
                                    </div>
                                    <div class="stui-foot clearfix">
                                        <div class="col-pd text-center hidden-xs">
                                        Dữ liệu phim miễn phí vĩnh viễn. Cập nhật nhanh, chất lượng cao, ổn định và lâu dài. Tốc độ phát cực nhanh với đường truyền băng thông cao, đảm bảo đáp ứng được lượng xem phim trực tuyến lớn. Đồng thời giúp nhà phát triển website phim giảm thiểu chi phí của các dịch vụ lưu trữ và stream.
                                        </div>
                                        <p class="share bdsharebuttonbox text-center margin-0 hidden-sm hidden-xs"></p>
                                        <p class="text-muted text-center visible-xs">Copyright © 2015-2024 <a href="/" target="_blank">OPHIMCMS</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT

                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT

                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
