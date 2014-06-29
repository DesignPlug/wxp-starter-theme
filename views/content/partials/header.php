  <header>
      
    <h2 class="entry-title">
       <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>  
     
    <?php get_template_part("views/content/partials/meta", view_var("content_type")); ?>  
      
    <?php if(has_post_thumbnail(get_the_ID()) && view_var("post_loop_show_thumb")): ?>
       <?php get_template_part("views/content/partials/thumbnail", view_var("content_type")); ?>
    <?php endif; ?>
      
  </header>

