  </div>
  <!-- footer -->
  <?php
  $store_parent = get_page_by_path('store');
  if (is_front_page() || $post->post_parent === $store_parent->ID || is_singular('post')) {
    get_template_part( 'template-parts/interview');
  }
  ?>
  <!-- linebnr -->
  <div id="linebnr"><a href="#LINE" target="_blank">
      <picture>
        <source media="(max-width:767px)" srcset="/recruit/lib/img/cmn/bnr_line_sp.webp">
        <source srcset="/recruit/lib/img/cmn/bnr_line.webp">
        <img src="/recruit/lib/img/cmn/bnr_line.webp" alt="先輩社員に聞いてみよう！見学・応募もLINEで！　LINE登録する">
      </picture>

    </a></div>

  <!-- requirementsLink -->
  <section id="requirementsLink">
    <div class="head">
      <h2>募集要項</h2>
      <div class="fukidashi01"><img src="/recruit/lib/img/cmn/img_requirements01.webp" alt="募集要項も、ぜひ見てみてくださいね"></div>
      <div class="fukidashi02"><img src="/recruit/lib/img/cmn/img_requirements02.webp" alt="一歩踏み出すなら、ここから"></div>
    </div>
    <div class="LinkContainer">
      <ul>
        <li><a href="/recruit/store/papios-higashi/">
            <div class="photo"><img src="/recruit/lib/img/cmn/store_papioshigashi.webp" alt=""></div>
            <p><span>オカノ薬局</span>パピオス東店</p>
          </a></li>
        <li><a href="/recruit/store/papios-nishi//">
            <div class="photo"><img src="/recruit/lib/img/cmn/store_papiosnishi.webp" alt=""></div>
            <p><span>オカノ薬局</span>パピオス西店</p>
          </a></li>
        <li><a href="/recruit/store/akashi-eki/">
            <div class="photo"><img src="/recruit/lib/img/cmn/store_akashieki.webp" alt=""></div>
            <p><span>オカノ薬局</span>明石駅店</p>
          </a></li>
        <li><a href="/recruit/store/eki-higashi/">
            <div class="photo"><img src="/recruit/lib/img/cmn/store_ekihigashi.webp" alt=""></div>
            <p><span>オカノ薬局</span>駅東店</p>
          </a></li>
        <li><a href="/recruit/store/aspia-mae/">
            <div class="photo"><img src="/recruit/lib/img/cmn/store_aspiamae.webp" alt=""></div>
            <p><span>オカノ薬局</span>アスピア前店</p>
          </a></li>

      </ul>
      <div class="entryform_btn"><a href="/recruit/entryform/">全店共通応募フォーム</a></div>
    </div>
  </section>
  <!-- footer -->
  <div id="footer">
    <footer>
      <div class="logo"><img src="/lib/img/cmn/footer_logo.webp" alt="オカノ薬局は明石市大明石町、明石駅近くの調剤薬局です。"></div>
      <p class="address">有限会社　オカノ薬局<br>
        〒673-0891　兵庫県明石市大明石町1-6-1</p>

      <ul class="otherLinks">
        <li><a href="/" class="home"><img src="/recruit/lib/img/cmn/bnr_okanograndtop.webp" alt="オカノ薬局"></a></li>
        <li><a href="/news/" class="info"><span class="en">Information</span><span class="jp">お知らせ</span></a></li>
        <li><a href="/blog/" class="blog"><span class="en">Blog</span><span class="jp">スタッフブログ</span></a></li>
        <li><a href="#" target="_blank" class="insta"><span class="en">Instagram</span><span class="jp">インスタグラム</span></a>
        </li>
      </ul>
    </footer>
    <div class="copy">
      <p>Copyright &copy; 2023-2026 <br class="sp">有限会社 オカノ薬局 All Rights Reserved.</p=>
    </div>
  </div>
  <div id="pagetop" class="pagetop"><a href="#contents">Page Top</a></div>

  <div id="fixedfooter">

  </div>
  <!-- /footer -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="/recruit/lib/js/swiper/swiper-bundle.min.js"></script>
  <?php $version = filemtime(ROOT . '/lib/js/main.js'); ?>
  <script src="/recruit/lib/js/main.js?ver=<?php echo $version; ?>"></script>
  <?php if (is_front_page()) : ?>
    <?php $version = filemtime(ROOT . '/lib/js/top.js'); ?>
    <script src="/recruit/lib/js/top.js?ver=<?php echo $version; ?>"></script>
  <?php endif; ?>
  <?php wp_footer(); ?>
  </body>

  </html>