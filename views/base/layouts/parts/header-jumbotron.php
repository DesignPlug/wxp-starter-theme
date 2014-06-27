<header id="layout-header" class="header-jumbotron">
    <?php get_template_part("views/base/layouts/parts/navtop", view_var("navtop_name")); ?>
    <section class="jumbotron">
        <div class="container">
            <h1><?php echo view_var("page_header_title"); ?></h1>
            <p><?php echo view_var("page_header_desc"); ?></p>
            <?php if(view_var("page_header_action")): ?>
            <p><a class="btn btn-primary btn-lg" 
                  href="<?php echo view_var("page_header_action_href"); ?>" 
                  role="button">
                    <?php echo view_var("page_header_action_text"); ?>
                </a>
            </p>
            <?php endif; ?>
        </div>
    </section>
</header>
<?php get_template_part("views/base/layouts/parts/header"); ?>
    
