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

function set_homepage_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);

    if ($page) {
        $page_id = $page->ID;
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_id);
    }
}

create_page_if_not_exists('accueil', 'Accueil');
create_page_if_not_exists('blog', 'Blog');
create_page_if_not_exists('contact', 'Contact');
create_page_if_not_exists('cookies', 'Cookies');
create_page_if_not_exists('faq', 'FAQ');
create_page_if_not_exists('plan-du-site', 'Plan du site');
create_page_if_not_exists('politique-de-confidentialite', 'Politique de confidentialité');
create_page_if_not_exists('prix', 'Prix');
create_page_if_not_exists('produits', 'Produits');
create_page_if_not_exists('v1', 'V1');
set_homepage_by_slug('accueil');
