<?php

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
