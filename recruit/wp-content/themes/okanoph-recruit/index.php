<?php get_header(); ?>
<!-- index.php -->
<div id="contents">
  <div id="mv">
    <div class="siteTitle">
      <p class="title">スタッフ採用</p>
      <p class="en">Recruit</p>
    </div>
    <picture>
      <source media="(max-width:767px)" srcset="/recruit/lib/img/cmn/mv_sp.webp">
      <source srcset="/recruit/lib/img/cmn/mv.webp">
      <img src="/recruit/lib/img/cmn/mv.webp" alt="">
    </picture>
  </div>
  <main>
    <div id="pageTitleBlock">
      <div class="interview"><img src="/recruit/lib/img/interview/pageTitle.webp" alt="先輩インタビュー"></div>
      <p class="sub">Staff Introduction</p>
      <h1 class="pagetitle">スタッフ紹介</h1>
    </div>
    <?php
    $post_type = get_post_type();
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
      <div id="staffvoice">
        <div class="head">
          <div class="fukidashi01"><img src="/recruit/lib/img/cmn/img_staffvoice_01.webp" alt="募集要項も、ぜひ見てみてくださいね"></div>
          <div class="fukidashi02"><img src="/recruit/lib/img/cmn/img_staffvoice_02.webp" alt="一歩踏み出すなら、ここから"></div>
        </div>
        <div id="interviewList">
          <div class="interviewListContainer">
            <?php while ($query->have_posts()) : $query->the_post(); ?>

              <div class="card"><a href="<?php the_permalink(); ?>">
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
                    </ul>
                  </div>
                </a>
              </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

          </div>
        </div>
      </div>
    <?php endif;  ?>
  </main>
</div>


<?php get_footer(); ?>