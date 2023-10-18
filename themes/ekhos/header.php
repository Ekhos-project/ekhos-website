<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<nav class="navigation">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'container' => false,
        'items_wrap' => '<ul>%3$s</ul>',
    ));
    ?>
</nav>