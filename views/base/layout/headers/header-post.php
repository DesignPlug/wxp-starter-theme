<header id="layout_header" class="header-post <?php echo $layout_header_class; ?>">
    <?php wxp_get_view("#layout_nav", $layout_nav); ?>
    <section class="page-header">
        <div class="container">
            <h1>
                <?php echo $layout_header_title; ?>
                <small>
                    <?php echo $layout_header_subtitle; ?>
                </small>
            </h1>
                <?php foreach($layout_header_tags as $tag): ?>
                    <a  class="btn btn-default"
                        href="<?php echo get_tag_link($tag->term_id); ?>" >
                        <?php echo strtoupper($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</header>
<?php wxp_get_view("#layout_header"); ?>