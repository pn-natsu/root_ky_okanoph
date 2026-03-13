    <?php
    $post_type = 'post';
    $args = [
      'posts_per_page' => -1,
      'post_type' => $post_type,
      'meta_key'   => 'interview_order',
      'orderby'    => 'meta_value_num',
      'order'      => 'ASC',
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) :
    ?>
      <!-- staffvoice -->
      <section id="staffvoice">
        <div class="head">
          <h2>スタッフ紹介<span>先輩インタビュー</span></h2>
          <div class="fukidashi01"><img src="/recruit/lib/img/cmn/img_staffvoice_01.webp" alt="チームワークの良さが自慢です"></div>
          <div class="fukidashi02"><img src="/recruit/lib/img/cmn/img_staffvoice_02.webp" alt="いろんなスタッフをご覧ください"></div>
        </div>

        <div id="interviewLinkContainer">

          <div class="swiper interviewSwiper">
            <div class="swiper-wrapper">
              <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="swiper-slide"><a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('large'); ?>
                    <?php else : ?>
                      <img src="/lib/img/cmn/no_image.png" alt="">
                    <?php endif; ?>
                    <div class="label">
                      <ul>
                        <?php if (get_field('hired_year')): ?>
                          <li class="year"><?php the_field('hired_year'); ?>年入社</li>
                        <?php endif; ?>
                        <?php
                        $job_title = get_field('job_title');
                        $job_type = get_the_category()[0]->name;
                        ?>
                        <li><?php if ($job_title): ?><?php echo $job_title; ?>/<?php endif; ?><?php echo $job_type; ?></li>
                        <?php if (get_field('name')): ?>
                          <li class="name"><?php the_field('name'); ?></li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </a>
                </div>
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
            </div>
          </div>
          <!-- ナビゲーション -->
          <div class="swiper-nav">
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <?php endif;  ?>