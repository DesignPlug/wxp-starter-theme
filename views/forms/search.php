<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
  <div class="input-group">
    <input type="search" value="<?php echo $form_search_query; ?>"
           name="s" class="<?php echo $form_search_input_class; ?>" 
           placeholder="<?php _e('Search', 'roots'); ?> <?php bloginfo('name'); ?>">
    <label class="hide"><?php echo $form_search_label; ?></label>
    <span class="input-group-btn">
      <button type="submit" 
              class="<?php echo $form_search_action_class?>">
                  <?php echo $form_search_action_text; ?>
      </button>
    </span>
  </div>
</form>
