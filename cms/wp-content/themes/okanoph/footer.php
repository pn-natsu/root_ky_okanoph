  </div>
  <!-- footer -->
  <?php
	include(ROOT . "/lib/inc/footer.html");
	?>
  <!-- /footer -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="/lib/js/swiper/swiper-bundle.min.js"></script>
  <?php $version = filemtime(ROOT . '/lib/js/main.js'); ?>
	<script src="/lib/js/main.js?ver=<?php echo $version; ?>"></script>
  <?php if (is_front_page()) : ?>
  	<?php $version = filemtime(ROOT . '/lib/js/top.js'); ?>
  	<script src="/lib/js/top.js?ver=<?php echo $version; ?>"></script>
  <?php endif; ?>
  <?php wp_footer(); ?>
  </body>

  </html>