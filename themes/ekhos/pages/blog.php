<?php ?>

<section class="section section-blog" id="title">
    <div class="title_container">
        <div class="title_title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog_title_icon.png" alt="blog">
            <h1>BLOG <b>IDS</b></h1>
            <p>Bienvenue sur le blog d’IDS.<br> Retrouvez tous les articles sur l’actualité de l’entreprise et de ces
                produits.</p>
        </div>
    </div>
</section>

<section class="section section-blog" id="blog">
    <div class="blog_container">
        <div class="blog_side">
            <div class="blog_side_recent">
                <h2>Articles récents</h2>
                <div class="blog_side_recent_items">
                    <?php
                    $args = array(
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="blog_side_recent_item">
                                <h3><?php the_title(); ?></h3>
                                <span><?php the_time('j F Y'); ?></span>
                            </a>
                            <?php
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <div class="blog_side_categories">
                <h2>Catégories</h2>
                <div class="blog_side_categories_items">
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order' => 'ASC'
                    ));
                    foreach ($categories as $category) {
                        $category_link = get_category_link($category->term_id);
                        echo '<a class="blog_side_categories_item" href="/blog/?category=' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="blog_side_social">
                <h2>Suivez-nous</h2>
                <div class="blog_side_social_items">
                    <a href="" class="blog_side_social_item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer_social_linkedin.png"
                             alt="Linkedin">
                    </a>
                    <a href="" class="blog_side_social_item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer_social_facebook.png"
                             alt="Facebook">
                    </a>
                    <a href="" class="blog_side_social_item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer_social_twitter.png"
                             alt="Twitter">
                    </a>
                    <a href="" class="blog_side_social_item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer_social_instagram.png"
                             alt="Instagram">
                    </a>
                </div>
            </div>
        </div>
        <div class="blog_cards">
            <?php
            $args = array(
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $categories = get_the_category();
                    $category = !empty($categories) ? $categories[0]: '';
                    ?>

                    <div class="blog_card" style="display: none;">
                        <div class="blog_card_image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="blog_card_content">
                            <h3 class="blog_card_content_title"><?php the_title(); ?></h3>
                            <span class="blog_card_content_category" data-slug="<?= $category->slug ?>"><?= $category->name ?></span>
                            <span class="blog_card_content_date"><?php the_time('j F Y'); ?></span>
                            <div class="blog_card_content_text"><?php the_excerpt(); ?></div>
                        </div>
                        <div class="blog_card_action">
                            <a href="<?php the_permalink(); ?>">En savoir plus</a>
                        </div>
                    </div>

                    <?php
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
