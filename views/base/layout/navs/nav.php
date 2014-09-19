<?php echo @$menu_drawer_template; ?>

<section class="navtop">
    <div class="container">
        <div class="<?php echo $layout_nav_brand_block_class; ?>">
            <?php wxp_get_view("#brand", $brand); ?>
        </div>
        <div class="<?php echo $layout_nav_menu_block_class; ?>">
            <?php wxp_get_view("#menu", $menu); ?>
            <?php wxp_get_view("#responsive_menu_trigger", @$responsive_menu_trigger); ?>
        </div>
    </div>
</section>