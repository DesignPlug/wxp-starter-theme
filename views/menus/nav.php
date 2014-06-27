<?php if (has_nav_menu(view_var('nav'))) : ?>
<nav class="nav-main pull-right <?php echo __var("primary_nav_class"); ?>" role="navigation">
    <?php wp_nav_menu(array('theme_location' => view_var('nav'), 'menu_class' => 'nav nav-pills')); ?> 
</nav>
<?php endif; ?>
