<?php get_header(); ?>
<?php
/*
    Template Name: Posts Page
*/
?>
<?php
if (have_posts()):
    while (have_posts()): the_post();
?>

<?php get_template_part('content', get_post_format()); ?>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>