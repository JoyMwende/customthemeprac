<?php

/**
 * Template Name: Portfolio Template
 */

get_header(); ?>

<?php
$args = [
    'post_type' => 'portfolio',
    'posts_per_page' => 3
];

$portfolios = new WP_Query($args);

if ($portfolios->have_posts()) :
    while ($portfolios->have_posts()) : $portfolios->the_post();
?>

        <div class="card">
            <div class="card-header">
                <?php the_title(sprintf('<h2 class="entry-title"> <a href="%s">', esc_url(get_permalink())), '</h2></a>'); ?>
            </div>
            <div class="card-body">
                <h5 class="thumbnail-img"><?php the_post_thumbnail('thumbnail'); ?></h5>
                <p class="card-text"><?php the_content(); ?></p>
                <p class="card-text"><?php the_category(); ?></p>
            </div>
        </div>

    <?php endwhile; ?>
<?php endif; ?>


<h6 href="#" class="card-link"><?php previous_post_link(); ?></h6>
<h6 href="#" class="card-link"><?php next_post_link() ?></h6>

<?php get_footer(); ?>