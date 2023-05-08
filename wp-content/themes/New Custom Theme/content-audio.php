<div class="d-flex flex-column bg-primary p-3 m-3">
    <h2>Audio Post Format</h2>
    <h4><?php the_title(sprintf('<h2 class="entry-title"><a href= "%s" class="text-decoration-none text-info">', esc_url(get_permalink())), '</a></h2>'); ?></h4>
    <p><?php the_content(); ?></p>
</div>
<hr color="blue">