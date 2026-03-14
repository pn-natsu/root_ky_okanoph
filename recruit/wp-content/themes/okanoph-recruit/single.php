<?php get_header(); ?>
<!-- single.php -->
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

    <!--pageMV-->
    <div class="pageMV">
      <?php if (get_field('mv')): ?>
        <div class="photo"><img src="<?php the_field('mv'); ?>" alt=""></div>
      <?php endif; ?>
      <?php
      $mv_text_position = get_field('mv_text_position');
      if ($mv_text_position === 'left') {
        $position_class = 'alignL';
      } elseif ($mv_text_position === 'right') {
        $position_class = 'alignR';
      } else {
        $position_class = 'alignR';
      }
      ?>
      <div class="panel <?php echo $position_class; ?>">
        <?php if (get_the_content()) : ?>
          <div class="lead"><?php the_content(); ?></div>
        <?php endif; ?>
        <div class="data">
          <?php if (get_field('hired_year')): ?>
            <p class="year"><?php the_field('hired_year'); ?>年入社</p>
          <?php endif; ?>
          <?php
          $job_title = get_field('job_title');
          $job_type = get_the_category()[0]->name;
          $position = get_field('position');
          ?>
          <ul>
            <li class="job"><?php if ($job_title): ?><?php echo $job_title; ?>/<?php endif; ?><?php echo $job_type; ?></li>
            <?php if ($position): ?>
              <li class="status"><?php echo $position; ?></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
    <!--/pageMV-->
    <?php if (have_rows('qa')) : $i = 1; ?>
      <div class="qaboxContainer">
        <?php while (have_rows('qa')) : the_row();
          $question = get_sub_field('question');
          $answer  = get_sub_field('answer');
        ?>
          <!-- item -->
          <div class="item">
            <div class="question">
              <hgroup>
                <p class="en">Question</p>
                <p class="num"><?php echo sprintf('%02d', $i); ?></p>
                <h3><?php echo $question; ?></h3>
              </hgroup>
            </div>
            <div class="answer">
              <?php echo $answer; ?>
            </div>
          </div>
        <?php $i++;
        endwhile; ?>
      </div>
    <?php endif; ?>
    <!--pager-->
    <ul class="pager">
      <?php
      $current_sort = get_post_meta(get_the_ID(), 'interview_order', true);
      $prev_post = get_posts(array(
        'meta_key'   => 'interview_order',
        'meta_query' => array(array('key' => 'interview_order', 'value' => $current_sort, 'compare' => '<', 'type' => 'NUMERIC')),
        'orderby'    => 'meta_value_num',
        'order'      => 'DESC',
        'posts_per_page' => 1
      ));
      $next_post = get_posts(array(
        'meta_key'   => 'interview_order',
        'meta_query' => array(array('key' => 'interview_order', 'value' => $current_sort, 'compare' => '>', 'type' => 'NUMERIC')),
        'orderby'    => 'meta_value_num',
        'order'      => 'ASC',
        'posts_per_page' => 1
      ));
      ?>
      <li>
        <?php if ($prev_post): ?>
          <a href="<?php echo get_permalink($prev_post[0]->ID); ?>">Prev</a>
        <?php else: ?>
          <span>Prev</span>
        <?php endif; ?>
      </li>
      <li><a href="<?php echo get_post_type_archive_link('post'); ?>">Interview INDEX</a></li>
      <li>
        <?php if ($next_post): ?>
          <a href="<?php echo get_permalink($next_post[0]->ID); ?>">Next</a>
        <?php else: ?>
          <span>Next</span>
        <?php endif; ?>
      </li>
    </ul>
    <!--/pager-->
  </main>
</div>

<?php get_footer(); ?>