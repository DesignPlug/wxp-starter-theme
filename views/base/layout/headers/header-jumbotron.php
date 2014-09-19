<header id="layout_header" class="header-jumbotron">
    <?php wxp_get_view("#layout_nav", $layout_nav); ?>
    
    <section class="jumbotron">
        <div class="container">
            
            <h1><?php echo $layout_header_title; ?></h1>
            <p><?php echo $layout_header_subtitle; ?></p>
            
            <?php if(@$layout_header_action): ?>
            <p><a class="btn btn-primary btn-lg" 
                  href="<?php echo $layout_header_action_href; ?>" 
                  role="button">
                    <?php echo $layout_header_action_text; ?>
                </a>
            </p>
            <?php endif; ?>
            
        </div>
    </section>
    
</header>
<?php wxp_get_view("#layout_header"); ?>
    
