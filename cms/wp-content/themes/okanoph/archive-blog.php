<?php get_header(); ?>
<?php
$post_type = get_post_type();
?>
<!-- archive-blog.php -->
<div id="contents">
  <div id="mv">
    <hgroup>
      <h1 class="title">スタッフブログ</h1>
      <p class="en">Blog</p>
    </hgroup>
    <picture>
      <source media="(max-width:767px)" srcset="/lib/img/blog/mv_sp.webp">
      <source srcset="/lib/img/blog/mv.webp">
      <img src="/lib/img/blog/mv.webp" alt="">
    </picture>
  </div>

  <div id="blogContainer">
    <main>
      <?php
      $raw_page = filter_input(INPUT_GET, 'pagenum');
      $pagenum = ($raw_page !== null) ? htmlspecialchars($raw_page) : '';
      $paged = (preg_match("/^[0-9]+$/", $pagenum)) ? $pagenum : 1;
      $args = [
        'posts_per_page' => 6,
        'post_type' => $post_type,
        'paged' => $paged,
      ];
      if (is_month()) {
        $year = get_query_var('year');
        $monthnum = get_query_var('monthnum');
        if ($year && $monthnum) {
          $args['date_query'] = [
            [
              'year'  => get_query_var('year'),
              'month' => get_query_var('monthnum'),
            ],
          ];
        }
        $title = esc_html($year) . '年' . esc_html($monthnum) . '月の記事';
      } else {
        $title = '最新の記事';
      }

      ?>

      <hgroup class="hgtype01">
        <h2 class="title"><?php echo $title; ?></h2>
      </hgroup>
      <?php
      $query = new WP_Query($args);
      if ($query->have_posts()) :
      ?>
        <div class="entrylist">
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <!-- entry -->
            <div class="item">
              <a href="<?php the_permalink(); ?>">
                <div class="thumb">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large'); ?>
                  <?php else : ?>
                    <img src="/lib/img/cmn/no_image.png" alt="">
                  <?php endif; ?>
                </div>
                <?php
                $terms = get_the_terms(get_the_ID(), 'blog-cat');
                if ($terms && ! is_wp_error($terms)) :
                ?>
                  <div class="category"><?php echo $terms[0]->name; ?></div>
                <?php endif; ?>
                <p class="date"><?php the_time('Y/m/d'); ?></p>
                <p class="title"><?php the_title(); ?></p>
              </a>
            </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>

          <!-- /entryContainer -->

        </div>
        <?php echo bmPageNavi($query); ?>
      <?php endif;  ?>




    </main>


    <?php get_sidebar('blog'); ?>

  </div>



</div>


<?php get_footer(); ?>