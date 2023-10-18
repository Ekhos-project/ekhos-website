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
