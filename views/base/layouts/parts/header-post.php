<header id="layout-header" class="header-post">
    <?php get_template_part("views/base/layouts/parts/navtop", view_var("navtop_name")); ?>
    <section class="page-header">
        <div class="container">
            <h1>
                <?php echo view_var("page_header_title"); ?>
                <small>
                    <?php echo view_var("page_header_subtitle"); ?>
                </small>
            </h1>
                <?php foreach(view_var('page_header_tags') as $tag): ?>
                    <a  class="btn btn-default"
                        href="<?php echo get_tag_link($tag->term_id); ?>" >
                        <?php echo strtoupper($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</header>
<?php get_template_part("views/base/layouts/parts/header"); ?>