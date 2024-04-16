<?php

function daisyui_style($hook) {
    if($hook != 'tools_page_ekhos-ids') {
        return;
    }
    global $wp_styles;
    foreach( $wp_styles->queue as $handle ) {
    }
    wp_enqueue_style('daisyui', 'https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css', array(), '4.6.0', 'all');
}

add_action('admin_enqueue_scripts', 'daisyui_style', 50);
function daisyui_script($hook) {
    if($hook != 'tools_page_ekhos-ids') {
        return;
    }
    wp_enqueue_script('daisyui', 'https://cdn.tailwindcss.com', array(), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'daisyui_script', 50);
function alpine_script($hook) {
    if($hook != 'tools_page_ekhos-ids') {
        return;
    }
    wp_enqueue_script('alpine', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '1.9.10', true);
}
add_action('admin_enqueue_scripts', 'alpine_script', 50);


function style_public() {
    wp_register_style('ekhos-style', plugins_url('/styles/style.css', __FILE__), array(), '1.0.0', 'all');
    wp_enqueue_style('ekhos-style');
}
add_action('wp_enqueue_scripts', 'style_public');
/*function ekhos_enqueue_scripts() {
    wp_enqueue_script('ekhos-script', plugins_url('/scripts/script.js', __FILE__), array(), null, true);
}
add_action('wp_enqueue_scripts', 'ekhos_enqueue_scripts');
function ekhos_add_type_attribute($tag, $handle, $src) {
    if ('ekhos-script' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}*/
/*add_filter('script_loader_tag', 'ekhos_add_type_attribute', 10, 3);*/
function append_public() {
    include_once('public.php');
}
add_action('wp_footer', 'append_public');