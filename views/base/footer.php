<footer class="footer" role="contentinfo">
  <div class="container">
      <div class="row">
          <?php dynamic_sidebar('sidebar-footer'); ?>
      </div>
      <div class="row">
          <div class="col-md-4">
              <p><?php echo $base_footer_copyright; ?></p>
          </div>
          <div class="col-md-8">
              <?php wxp_get_view("#social_networks", $social_networks); ?>
          </div>
      </div>
  </div>
</footer>

<?php wp_footer(); ?>
<?php do_action("get_footer"); ?>

</body>
</html>
