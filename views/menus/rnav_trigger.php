<?php if (has_nav_menu(view_var('rnav')) && view_var('use_rnav')) : ?>

<!-- sidr nav trigger -->

<a href="#sidr" 
   class="btn btn-default sidr-toggle hidden-lg hidden-md pull-<?php echo view_var("rnav_position"); ?>">
    <i class="fa fa-bars"></i>
</a>

<?php endif; ?>