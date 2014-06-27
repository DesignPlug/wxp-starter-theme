<header id="layout-header" class="header-jumbotron">
    <?php get_template_part("views/base/layouts/parts/navtop", view_var("navtop_name")); ?>
    <section class="jumbotron">
        <div class="container">
            <?php __var("header_slider"); ?>
        </div>
    </section>
</header>
<?php get_template_part("views/base/layouts/parts/header"); ?>