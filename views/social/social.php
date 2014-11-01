<?php if(@$social_network_links): ?>    
    <ul id="footer-social-links">
    <?php foreach($social_network_links as $link): ?>
        <li>
          <a href="<?php echo $link->link; ?>">
              <i class="fa fa-<?php echo $link->id; ?>" title="<?php echo $link->name; ?>"></i>
          </a>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

