<?php
global $page_slug;
$page_slug = get_post_field('post_name', get_post());

get_header();

if (is_front_page()) {
    include_once get_template_directory() . "/pages/home.php";
} else {
    $path = get_template_directory() . "/pages/" . $page_slug . ".php";
    if (file_exists($path)) {
        include_once $path;
    } else {
//        include_once get_template_directory() . "/pages/404.php";
    }
}

get_footer();
