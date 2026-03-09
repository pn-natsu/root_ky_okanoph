  </div>
  <!-- footer -->
  <div id="footer">

    <div class="logo"><img src="/lib/img/cmn/footer_logo.webp" alt="オカノ薬局は明石市大明石町、明石駅近くの調剤薬局です。"></div>
    <p class="address">有限会社　オカノ薬局<br>
      〒673-0891　兵庫県明石市大明石町1-6-1</p>
    <footer>
      <!-- gnav js.clon from  #header -->
      <div class="barlist">
        <?php
        $parent_page = get_page_by_path('store');
        if ($parent_page) {
          $args = array(
            'post_type'      => 'page',
            'post_parent'    => $parent_page->ID,
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC'
          );
          $child_query = new WP_Query($args);
        }
        if ($child_query->have_posts()):
        ?>

          <dl class="shopList">
            <dt>店舗紹介</dt>
            <dd>
              <ul>
                <?php while ($child_query->have_posts()):
                  $child_query->the_post();
                ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile;
                wp_reset_postdata(); ?>
              </ul>
            </dd>
          </dl>
        <?php endif; ?>
        <dl class="recruitList">
          <dt><a href="/recruit/">スタッフ採用</a></dt>
          <dd>
            <ul>
              <li><a href="/recruit/store/papios-higashi/">パピオス東店</a></li>
              <li><a href="/recruit/store/papios-nishi/">パピオス西店</a></li>
              <li><a href="/recruit/store/akashi-eki/">明石駅店</a></li>
              <li><a href="/recruit/store/eki-higashi/">駅東店</a></li>
              <li><a href="/recruit/store/aspia-mae/">アスピア前店</a></li>
            </ul>
          </dd>
          <dd class="entryform"><a href="/recruit/entryform/">応募フォーム</a></dd>
        </dl>
      </div>
      <ul class="otherLinks">
        <li><a href="<?php echo get_post_type_archive_link('post'); ?>" class="info"><span class="en">Information</span><span class="jp">お知らせ</span></a></li>
        <li><a href="<?php echo get_post_type_archive_link('blog'); ?>" class="blog"><span class="en">Blog</span><span class="jp">スタッフブログ</span></a></li>
        <li><a href="https://www.instagram.com/okanogram/" target="_blank" class="insta"><span class="en">Instagram</span><span class="jp">インスタグラム</span></a>
        </li>
      </ul>

      <div class="copy">
        <p>Copyright &copy; 2023-2026 <br class="sp">有限会社 オカノ薬局 All Rights Reserved.</p=>
      </div>
    </footer>
  </div>
  <div id="pagetop" class="pagetop"><a href="#contents">Page<br>Top</a></div>

  <div id="fixedfooter">

  </div>
  <!-- /footer -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
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