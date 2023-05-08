<div class="d-flex flex-column bg-success p-3 m-3">
    <h2>Gallery Post Format</h2>
    <h4><?php the_title(sprintf('<h2 class="entry-title"><a href= "%s" class="text-decoration-none text-info">', esc_url(get_permalink())), '</a></h2>'); ?></h4>
    <div class="d-flex flex-row justify-content-center align-content-center gap-4"><?php the_content(); ?></div>
</div>
<hr color="blue">