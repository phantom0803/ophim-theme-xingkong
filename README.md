# THEME - XING KONG 2024 - OPHIM CMS

## Demo
https://forum.ophim.cc/d/30-theme-xingkong

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/theme-xingkong`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/theme-xingkong`
2. Re-Activate giao diện trong Admin Panel

## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes

## Document
### List
- Home page: `display_label|display_description|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_more_url|section_template(default|with_top)`
####
    Phim chiếu rạp mới||is_shown_in_theater|1|created_at|desc|12|/danh-sach/phim-chieu-rap|default
    Phim bộ mới||type|series|updated_at|desc|10|/danh-sach/phim-bo|with_top
    Phim lẻ mới||type|single|updated_at|desc|10|/danh-sach/phim-le|with_top
    Phim hoạt hình mới|categories|slug|hoat-hinh|updated_at|desc|10|/the-loai/hoat-hinh|with_top
####

- Cột phải: `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit`
####
    Top phim lẻ||type|single|view_week|desc|8
    Top phim bộ||type|series|view_week|desc|8
    Phim sắp chiếu||status|trailer|publish_year|desc|8
####

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-xingkong/resources/views/themexingkong`
- Copy file cần custom đến: `/resources/views/vendor/themes/xingkong`

