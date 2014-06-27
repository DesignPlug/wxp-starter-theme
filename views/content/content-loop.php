<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('views/content/content', view_var("content_type")); ?>
<?php endwhile; ?>

<?php if(view_var("paged_archive")): ?>
    <?php get_template_part("views/content/partials/pager", view_var("pager_name")); ?>
<?php endif; ?>
