<?php
get_header();
?>

<section class="section section-blog" id="title">
    <div class="title_container">
        <div class="title_title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog_title_icon.png" alt="blog">
            <h1><?php the_title(); ?></h1>
            <p>Publié le <?php the_time('j F Y'); ?></p>
        </div>
    </div>
</section>

<section class="section section-single" id="image">
    <div class="image_container">
        <div class="image_visual">
            <img src="<?= get_the_post_thumbnail_url() ?>" alt="article">
        </div>
    </div>
</section>

<section class="section section-single" id="article">
    <div class="article_container">
        <main class="article_main">
            <?php the_content(); ?>
        </main>
    </div>
</section>

<section class="section section-single" id="more">
    <div class="more_container">
        <div class="more_title">
            <h2>Autres articles</h2>
        </div>
        <div class="more_cards">
            <?php
            $args = array(
                'posts_per_page' => 2,
                'orderby' => 'date',
                'post__not_in'   => array( $post->ID ),
                'no_found_rows'  => true,
                'order' => 'DESC'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $categories = get_the_category();
                    $category = !empty($categories) ? $categories[0] : '';
                    ?>

                    <div class="more_card">
                        <div class="more_card_image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="more_card_content">
                            <h3 class="more_card_content_title"><?php the_title(); ?></h3>
                            <span class="more_card_content_category"
                                  data-slug="<?= $category->slug ?>"><?= $category->name ?></span>
                            <span class="more_card_content_date"><?php the_time('j F Y'); ?></span>
                            <div class="more_card_content_text"><?php the_excerpt(); ?></div>
                        </div>
                        <div class="more_card_action">
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

<?php
get_footer();
?>
