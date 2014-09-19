<!-- #loop template -->

<?php wxp_get_view("#loop_header", $loop_header); ?>

<?php while (have_posts()) : the_post(); ?>
    <?php wxp_get_view("#content", $content); ?>
<?php endwhile; ?>

<?php wxp_get_view("#loop_footer", $loop_footer); ?>

<!-- /#loop template -->


