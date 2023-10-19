<?php wp_footer(); ?>
</div>

<footer>
    <div class="footer_demo">
        <div class="footer_demo_container">
            <div class="footer_demo_text">
                <h3>Testez, c’est approuvé !</h3>
                <p>Découvrez notre solution à travers une démo depuis un navigateur web.</p>
            </div>
            <div class="footer_demo_try">
                <a href="" class="button endicon">Essayer</a>
            </div>
        </div>
    </div>

    <div class="footer_newsletter">
        <div class="footer_newsletter_container">
            <div class="footer_newsletter_text">
                <p>Restez connecté avec nous. Inscrivez-vous à la newsletter EKHOS !</p>
            </div>

            <div class="footer_newsletter_action">
                <?= do_shortcode('[contact-form-7 id="44" title="newsletter"]'); ?>
            </div>
        </div>
    </div>

    <div class="footer_navigation">
        <div class="footer_navigation_container">
            <a href="" class="footer_navigation_logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.png" alt="Ekhos">
            </a>
            <div class="footer_navigation_menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'container' => false,
                    'items_wrap' => '<ul>%3$s</ul>',
                ));
                ?>
            </div>
        </div>
    </div>

    <div class="footer_social">
        <div class="footer_social_title">
            Suivez-nous sur les réseaux sociaux !
        </div>
        <div class="footer_social_links">
            <a href="" class="footer_social_link">
                <img src="" alt="">
            </a>

            <a href="" class="footer_social_link">
                <img src="" alt="">
            </a>

            <a href="" class="footer_social_link">
                <img src="" alt="">
            </a>

            <a href="" class="footer_social_link">
                <img src="" alt="">
            </a>
        </div>
    </div>

    <div class="footer_legals">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'legals-menu',
            'container' => false,
            'items_wrap' => '<ul>%3$s</ul>',
        ));
        ?>
    </div>
</footer>

<script src=<?php echo get_template_directory_uri(); ?>/assets/scripts/script.js" type="module"></script>
</body>
</html>
