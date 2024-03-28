<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/styles/demo/style.css">
</head>
<body <?php body_class(get_post()->post_name) ?>>

<header>
    <div class="header_content">
        <a href="" class="header_logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/header_logo_icon.png" alt="logo">
        </a>

        <div class="header_burger">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/header_burger_icon.png" alt="burger">
        </div>
    </div>
</header>

<div class="container">
    <section class="section section-home" id="hero">
        <div class="hero_container">
            <h1>Racontons votre histoire !</h1>

            <p>Ceci est une page de présentation de notre plug-in IdSound. À partir de cette page, vous pourrez
                constater le storyboard mis en place mettant en avant l’univers que vous souhaitez présenter à vos
                clients.</p>

            <p>Ne soyez plus spectateur, soyez l’acteur !</p>
        </div>
        <div class="hero_background">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/home_hero_background.png"
                 alt="background">
        </div>
    </section>

    <section class="section section-home" id="product">
        <div class="product_container">
            <div class="product_text">
                <h2>Ceci est votre produit</h2>
                <p>C’est ici que tout commence ! Depuis un storyboard et votre storytelling, créer votre histoire pour
                    mettre en avant votre produit. Votre son et votre voix vous accompagnera tous le long de votre
                    aventure !</p>
            </div>

            <div class="product_visual">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/home_product_image.png"
                     alt="visual">
            </div>
        </div>

        <div class="section-splitter"></div>
    </section>

    <section class="section section-home" id="sound">
        <div class="sound_container">
            <div class="sound_text">
                <h2>À travers le son et la voix</h2>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                    nulla pariatur.</p>
            </div>

            <div class="sound_visual">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/home_sound_image.png" alt="visual">
            </div>
        </div>
        <div class="section-splitter"></div>
    </section>

    <section class="section section-home" id="story">
        <div class="story_container">
            <div class="story_text">
                <h2>Votre histoire, un chemin</h2>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                    nulla pariatur.</p>
                <i class="story_action"></i>
            </div>

            <div class="story_visual">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/home_story_image.png" alt="visual">
            </div>
        </div>
    </section>
    <?php
    wp_footer();
    ?>
</div>

<footer>
    <div class="footer_container">
        <div class="footer_title">
            <h2>Il ne reste qu’une seule chose à faire…</h2>
        </div>

        <div class="footer_action">
            <a class="button endicon" href="/prix/">Faire un devis</a>
        </div>

        <div class="footer_logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/demo/footer_logo_image.png" alt="logo">
        </div>
    </div>
</footer>

<script src="<?php echo get_template_directory_uri(); ?>/assets/scripts/demo/script.js" type="module"></script>
</body>
</html>