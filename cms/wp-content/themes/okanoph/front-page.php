<?php get_header(); ?>
<!-- front-page.php -->
<div id="contents">
  <div id="mv">

    <picture>
      <source media="(max-width:767px)" srcset="/lib/img/top/mv.webp">
      <source srcset="/lib/img/top/mv.webp">
      <img src="/lib/img/top/mv.webp" alt="">
    </picture>
  </div>
  <main>
    <!-- about -->
    <section id="instagram">
      <hgroup class="htype01">
        <p class="en">Instagram</p>
        <h2>インスタグラム</h2>
      </hgroup>
      <?php echo do_shortcode('[instagram-feed feed=2]'); ?>
      <div class="link"><a href="https://www.instagram.com/okanogram/" target="_blank">もっと見る</a></div>
    </section>

    <?php
    $posts_per_page = 2;
    $pickup_args = array(
      'posts_per_page' => $posts_per_page,
      'meta_query' => array(
        array(
          'key'     => 'pickup',
          'value'   => 1,
          'compare' => '=',
        )
      ),
    );
    $pickup_posts = get_posts($pickup_args);

    $exclude_ids = wp_list_pluck($pickup_posts, 'ID');
    $pickup_count = count($pickup_posts);
    $normal_posts = array();
    if ($posts_per_page > $pickup_count) {
      $normal_args = array(
        'posts_per_page' => $posts_per_page - $pickup_count,
        'post__not_in'   => $exclude_ids,
      );
      $normal_posts = get_posts($normal_args);
    }
    $all_posts = array_merge($pickup_posts, $normal_posts);
    if (!empty($all_posts)): global $post;
    ?>

      <!-- information -->
      <section id="information">
        <div class="infoContainer">
          <div class="infoHead">
            <hgroup class="htype01">
              <p class="en">Information</p>
              <h2>お知らせ</h2>
            </hgroup>
            <?php

            $page = get_page_by_path('news/indexlist');
            if ($page) {
              $list_url = get_permalink($page->ID);
            } else {
              $list_url = get_post_type_archive_link('post');
            }
            ?>

            <p class="link"><a href="<?php echo $list_url; ?>">お知らせ一覧へ</a></p>
          </div>
          <div class="infolist">
            <ul>
              <?php foreach ($all_posts as $post): setup_postdata($post); ?>
                <?php if (get_field('disp_body')): ?>
                  <li>
                    <div>
                      <span><?php the_time('Y/m/d'); ?></span>
                      <div class="entryBody">
                        <p class="title"><?php the_title(); ?></p>
                        <?php the_content(); ?>
                      </div>
                    </div>
                  </li>
                <?php else: ?>
                  <li><a href="<?php the_permalink(); ?>"><span><?php the_time('Y/m/d'); ?></span><?php the_title(); ?></a></li>
                <?php endif; ?>
              <?php endforeach;
              wp_reset_postdata(); ?>
            </ul>
          </div>
        </div>
      </section>
    <?php endif; ?>
    <!-- about -->
    <section id="about">
      <ul class="headPhoto moviescroll">
        <li><img src="/lib/img/top/about_05.webp" alt=""></li>
        <li><img src="/lib/img/top/about_06.webp" alt=""></li>
        <li><img src="/lib/img/top/about_07.webp" alt=""></li>
        <li><img src="/lib/img/top/about_01.webp" alt=""></li>
        <li><img src="/lib/img/top/about_02.webp" alt=""></li>
        <li><img src="/lib/img/top/about_03.webp" alt=""></li>
        <li><img src="/lib/img/top/about_04.webp" alt=""></li>
      </ul>
      <h2><img src="/lib/img/top/about_lead.webp" alt="手から手へ 心からこころとからだの健康へ"></h2>

      <div class="aboutContainer">
        <div class="person01"><img src="/lib/img/top/about_person_02.webp" alt=""></div>
        <div class="detail">
          <p class="lead">明石海峡を望む<br class="sp">穏やかな港町、明石</p>
          <p>この地でオカノ薬局は 約100年前に創業しました。<br>
            開局以来変わらず持ち続けている私たちの信念は<br>
            「地域の人々と寄り添い続ける」ということ<br>
            手から手へ 心からこころとからだの健康へ<br>
            これからも地域とともに発展し、<br class="md">よりよい未来へ歩み続けます。</p>

          <p class="link"><a href="/about/">会社案内へ</a></p>
        </div>
        <div class="person02"><img src="/lib/img/top/about_person_01.webp" alt=""></div>
      </div>
      <ul class="bottomPhoto moviescroll">
        <li><img src="/lib/img/top/about_01.webp" alt=""></li>
        <li><img src="/lib/img/top/about_02.webp" alt=""></li>
        <li><img src="/lib/img/top/about_03.webp" alt=""></li>
        <li><img src="/lib/img/top/about_04.webp" alt=""></li>
        <li><img src="/lib/img/top/about_05.webp" alt=""></li>
        <li><img src="/lib/img/top/about_06.webp" alt=""></li>
        <li><img src="/lib/img/top/about_07.webp" alt=""></li>
      </ul>
    </section>
    <?php
    $args = [
      'posts_per_page' => 3,
      'post_type' => 'blog',
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) :
    ?>

      <!-- blog -->
      <div id="blog">
        <hgroup class="htype01">
          <p class="en">Blog</p>
          <h2>オカノ薬局スタッフブログ</h2>
        </hgroup>

        <div class="blogContainer">
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <!-- item -->
            <div class="item"><a href="<?php the_permalink(); ?>">
                <div class="photo">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large'); ?>
                  <?php else : ?>
                    <img src="/lib/img/cmn/no_image.png" alt="">
                  <?php endif; ?>
                </div>
                <p class="date"><?php the_time('Y/m/d'); ?></p>
                <p class="title"><?php the_title(); ?></p>
                <div class="link">もっと見る</div>
              </a>
            </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    <?php endif; ?>
    <!-- mendan bnr -->
    <div id="mendan">
      <a href="/recruit/">
        <picture>
          <source media="(max-width:767px)" srcset="/lib/img/top/bnr_recruit_sp.webp">
          <source srcset="/lib/img/top/bnr_recruit_pc.webp">
          <img src="/lib/img/top/bnr_recruit_pc.webp" alt="オカノ薬局採用サイト">
        </picture>
      </a>
    </div>

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
      <!-- store info -->
      <section id="storeinfo">
        <hgroup class="htype01">
          <p class="en">Store Information</p>
          <h2>店舗のご案内</h2>
        </hgroup>
        <div id="storeinfoList">
          <div class="slider">
            <?php while ($child_query->have_posts()):
              $child_query->the_post();
              $slug = get_post_field('post_name', get_the_ID());
              $slug_no_hifun = str_replace('-', '', $slug);
            ?>
              <!-- store -->
              <div class="slide <?php echo $slug; ?>">
                <a href="<?php the_permalink(); ?>" class="store_<?php echo $slug_no_hifun; ?>">
                  <div class="photo"><img src="/lib/img/cmn/store_<?php echo $slug_no_hifun; ?>.webp" alt="オカノ薬局 <?php the_title(); ?>"></div>
                  <p><span>オカノ薬局</span> <?php the_title(); ?></p>
                  <div class="icon"></div>
                </a>
              </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- featureService -->
    <div id="featureService">
      <section>
        <a href="/zaitaku/">
          <div class="photo"><img src="/lib/img/top/featureService_01.webp" alt=""></div>
          <dl>
            <dt>在宅医療</dt>
            <dd>薬剤師がご自宅を訪問し、生活状況や体調に合わせて、お薬管理を行います。<br>
              在宅での安心した療養生活をサポートいたします。</dd>
          </dl>
        </a>
      </section>
      <section>
        <a href="/mimotohosho/">
          <div class="photo"><img src="/lib/img/top/featureService_02.webp" alt=""></div>
          <dl>
            <dt>身元保証サービス</dt>
            <dd>ご家族が遠方にお住まいの方や一人暮らしの方も安心できるよう、身元保証サービスを通じて日常の支えとなるお手伝いをしています。</dd>
          </dl>
        </a>
      </section>
    </div>


  </main>
</div>

<?php get_footer(); ?>