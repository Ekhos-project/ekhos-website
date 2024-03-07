<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/styles/style.css">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" />
    <?php if (is_front_page()) : ?>
        <title><?php echo get_bloginfo('name'); ?></title>
    <?php else : ?>
        <title><?php echo get_bloginfo('name') . " | " . wp_title('', false); ?></title>
    <?php endif; ?>
</head>
<body <?php body_class(get_post()->post_name)?>>

<header>
    <nav>
        <div class="navigation_container">
            <a href="/" class="navigation_logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/header_logo_ekhos.png" alt="Ekhos">
            </a>
            <div class="navigation_menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container' => false,
                    'items_wrap' => '<ul>%3$s</ul>',
                ));
                ?>
            </div>
            <button class="navigation_burger"></button>
        </div>
    </nav>
</header>

<div class="container">
