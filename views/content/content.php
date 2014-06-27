<article <?php post_class(); ?>>

  <?php get_template_part("views/content/partials/header", view_var("content_type")); ?>
    
  <?php get_template_part("views/content/partials/content", view_var("post_loop_content_read")); ?>
    
</article>