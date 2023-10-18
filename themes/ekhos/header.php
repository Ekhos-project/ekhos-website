<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/styles/style.css">
</head>
<body <?php body_class(); ?>>

<header>
    <nav class="navigation">
        <div class="navigation_logo">
            <img src="" alt="">
        </div>
        <div class="navigation_menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'container' => false,
                'items_wrap' => '<ul>%3$s</ul>',
            ));
            ?>
        </div>
    </nav>
</header>

<div class="container">
