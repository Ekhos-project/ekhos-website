<?php ?>

<section class="section section-faq" id="title">
    <div class="faq_container">
        <div class="faq_title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/faq_title_icon.png" alt="faq">
            <h1>Foire aux questions</h1>
            <p>Trouvez des réponses à vos questions.</p>
        </div>
    </div>
</section>

<section class="section section-faq" id="questions">
    <div class="questions_container">
        <div class="questions_content">
            <div class="questions_items">
                <?php
                $args = array(
                    'post_type' => 'questions',
                    'posts_per_page' => -1,
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $title = get_the_title();
                        $reponse = get_field('reponse');
                        $mise_en_avant = get_field('avant');
                        ?>
                        <div class="questions_item">
                            <div class="questions_item_expand"></div>
                            <div class="questions_item_title">
                                <span><?= $title ?></span>
                            </div>
                            <div class="questions_item_response">
                                <p><?= $reponse ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</section>
