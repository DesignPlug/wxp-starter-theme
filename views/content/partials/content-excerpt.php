<div class="entry-summary clearfix">
      <?php the_excerpt(); ?>
      <div class="actions">
          <a href="<?php the_permalink(); ?>" 
             class="pull-right btn btn-primary">
               <?php echo view_var("read_more_text"); ?>
          </a>
      </div>
</div>