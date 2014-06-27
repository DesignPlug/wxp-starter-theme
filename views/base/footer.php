<footer class="footer" role="contentinfo">
  <div class="container">
      <div class="row">
          <?php dynamic_sidebar('sidebar-footer'); ?>
      </div>
      <div class="row">
          <div class="col-md-4">
              <p><?php echo view_var("copyright_footer"); ?></p>
          </div>
          <div class="col-md-8">
              <?php get_template_part("views/social/networks"); ?>
          </div>
      </div>
  </div>
</footer>

<?php wp_footer(); ?>
<?php do_action("get_footer"); ?>

</body>
</html>
