<?php
get_header();

global $page_slug;
$page_slug = get_post_field('post_name', get_post());

if (is_front_page()) {
    include_once get_template_directory() . "/pages/home.php";
} else {
    $path = get_template_directory() . "/pages/" . $page_slug . ".php";
    if (file_exists($path)) {
        include_once $path;
    } else {
        echo "building...";
    }
}

get_footer();
