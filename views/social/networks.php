<?php if(view_var("social_links")): ?>    
    <ul id="footer-social-links">
    <?php foreach(view_var("social_links") as $link): ?>
        <li>
          <a href="<?php echo $link->link; ?>">
              <i class="fa fa-<?php echo $link->id; ?>" title="<?php echo $link->name; ?>"></i>
          </a>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

