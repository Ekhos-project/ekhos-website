<?php

add_action('init', 'set_permalink');

function set_permalink(){
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}

function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Menu Header' ),
            'footer-menu' => __( 'Menu Footer' ),
            'legals-menu' => __( 'Menu Legals' )
        )
    );
}
add_action( 'init', 'register_my_menus' );

add_filter('wpcf7_autop_or_not', '__return_false');

add_theme_support('post-thumbnails');

function disable_email_login( $user, $username, $password ) {
    if ( is_email( $username ) ) {
        return new WP_Error( 'disabled_email_login', __("<strong>ERREUR</strong> : La connexion par email est désactivée. Veuillez utiliser votre nom d'utilisateur.") );
    }
    return $user;
}
add_filter( 'authenticate', 'disable_email_login', 20, 3 );

function create_page_if_not_exists($page_slug, $page_title) {
    $existing_page = get_page_by_path($page_slug, OBJECT, 'page');

    if (!$existing_page) {
        $page_data = array(
            'post_title'    => wp_strip_all_tags($page_title),
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => $page_slug
        );
        $page_id = wp_insert_post($page_data);
    }
}

function create_and_assign_menu($menu_name, $menu_location) {
    $menu_exists = wp_get_nav_menu_object($menu_name);
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
    } else {
        $menu_id = $menu_exists->term_id;
    }
    $locations = get_theme_mod('nav_menu_locations');
    $locations[$menu_location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

create_and_assign_menu('Menu header', 'header-menu');
create_and_assign_menu('Menu footer', 'footer-menu');
create_and_assign_menu('Menu legals', 'legals-menu');


function add_page_to_menu($menu_name, $page_slug, $page_title = null, $classes_array = array(), $parent_id = 0){
    $menu_obj = wp_get_nav_menu_object($menu_name);

    if (!$menu_obj) {
        return;
    }

    $menu_id = $menu_obj->term_id;

    $page = get_page_by_path($page_slug);
    if (!$page) {
        return;
    }
    $page_id = $page->ID;

    $menu_items = wp_get_nav_menu_items($menu_id);
    foreach ($menu_items as $menu_item) {
        if ($menu_item->object_id == $page_id) {
            return;
        }
    }

    $result = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => $page_title ? $page_title : $page->post_title,
        'menu-item-object-id' => $page_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish',
        'menu-item-classes' => implode(' ', $classes_array),
        'menu-item-parent-id' => $parent_id,
    ));

    return $result;
}


function create_menu_item($menu_name, $title, $url = '', $parent_id = 0) {
    $menu_obj = wp_get_nav_menu_object($menu_name);
    if (!$menu_obj) {
        return;
    }
    $menu_id = $menu_obj->term_id;

    $menu_items = wp_get_nav_menu_items($menu_id);
    foreach ($menu_items as $menu_item) {
        if ($menu_item->title == $title) {
            return $menu_item->ID;
        }
    }
    return wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => $title,
        'menu-item-url' => $url,
        'menu-item-status' => 'publish',
        'menu-item-parent-id' => $parent_id,
        'menu-item-type' => 'custom',
    ));
}


function set_homepage_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);

    if ($page) {
        $page_id = $page->ID;
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_id);
    }
}

function activate_all_plugins() {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    $all_plugins = get_plugins();
    $inactive_plugins = array();

    foreach ($all_plugins as $plugin_path => $plugin) {
        if (!is_plugin_active($plugin_path)) {
            $inactive_plugins[] = $plugin_path;
        }
    }

    if (!empty($inactive_plugins)) {
        activate_plugins($inactive_plugins);
    }
}

function add_pages() {
    create_page_if_not_exists('accueil', 'Accueil');
    create_page_if_not_exists('blog', 'Blog');
    create_page_if_not_exists('contact', 'Contact');
    create_page_if_not_exists('cookies', 'Cookies');
    create_page_if_not_exists('demo', 'Demo');
    create_page_if_not_exists('faq', 'FAQ');
    create_page_if_not_exists('plan-du-site', 'Plan du site');
    create_page_if_not_exists('politique-de-confidentialite', 'Politique de confidentialité');
    create_page_if_not_exists('prix', 'Prix');
    create_page_if_not_exists('produits', 'Produits');
    create_page_if_not_exists('v1', 'V1');
    set_homepage_by_slug('accueil');
    add_page_to_menu('Menu header', 'produits');
    $ressources = create_menu_item('Menu header', 'Ressources', '#ressources');
    add_page_to_menu('Menu header', 'blog', null, array(), $ressources);
    add_page_to_menu('Menu header', 'faq', null, array(), $ressources);
    add_page_to_menu('Menu header', 'prix');
    add_page_to_menu('Menu header', 'contact');
    add_page_to_menu('Menu header', 'demo', 'Essayer', array('demo'));
    add_page_to_menu('Menu footer', 'produits');
    add_page_to_menu('Menu footer', 'faq');
    add_page_to_menu('Menu footer', 'blog');
    add_page_to_menu('Menu footer', 'contact');
    add_page_to_menu('Menu legals', 'politique-de-confidentialite');
    add_page_to_menu('Menu legals', 'cookies');
    add_page_to_menu('Menu legals', 'v1');
    add_page_to_menu('Menu legals', 'plan-du-site');
}

function theme_activation() {
    if (get_option('theme_activation_exec', false) == false) {
        add_pages();
        activate_all_plugins();
        update_option('theme_activation_exec', true);
    }
}
theme_activation();
