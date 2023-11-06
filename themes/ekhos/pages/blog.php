<?php ?>

<section class="section section-blog" id="title">
    <div class="title_container">
        <div class="title_title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog_title_icon.png" alt="blog">
            <h1>BLOG <b>EKHOS</b></h1>
            <p>Bienvenue sur le blog d’EKHOS.<br> Retrouvez tous les articles sur l’actualité de l’entreprise et de ces
                produits.</p>
        </div>
    </div>
</section>

<section class="section section-blog" id="blog">
    <div class="blog_container">
        <div class="blog_side">
            <div class="blog_side_recent">
                <h2>Articles récents</h2>
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
            <div class="blog_side_categories">

            </div>
            <div class="blog_side_social">

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
                    $category = !empty($categories) ? $categories[0]->name : '';
                    ?>

                    <div class="blog_card">
                        <div class="blog_card_image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="blog_card_content">
                            <h3 class="blog_card_content_title"><?php the_title(); ?></h3>
                            <span class="blog_card_content_category"><?= $category ?></span>
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
