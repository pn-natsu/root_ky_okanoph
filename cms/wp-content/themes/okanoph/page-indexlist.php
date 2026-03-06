<?php
/*
Template Name: お知らせ一覧ページ
*/
?>
<?php get_header(); ?>
<!-- page-indexlist.php -->
<div id="contents">
  <div id="mv">
    <hgroup>
      <h1 class="title">お知らせ</h1>
      <p class="en">Information</p>
    </hgroup>
    <picture>
      <source media="(max-width:767px)" srcset="/lib/img/news/mv_sp.webp">
      <source srcset="/lib/img/news/mv.webp">
      <img src="/lib/img/news/mv.webp" alt="">
    </picture>
  </div>
  <main>
    <?php
    $raw_page = filter_input(INPUT_GET, 'pagenum');
    $pagenum = ($raw_page !== null) ? htmlspecialchars($raw_page) : '';
    $paged = (preg_match("/^[0-9]+$/", $pagenum)) ? $pagenum : 1;
    $args = [
      'posts_per_page' => 12,
      'post_type' => 'post',
      'paged' => $paged,
    ];
    if (isset($term->slug)) {
      $args['category_name'] = $term->slug;
    }
    $query = new WP_Query($args);
    if ($query->have_posts()) :
    ?>

      <div class="indexlist">
        <ul>
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <li><span><?php the_time('Y/m/d'); ?></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        </ul>
      </div>
      <?php echo bmPageNavi($query); ?>
    <?php endif;  ?>
  </main>
</div>

<?php get_footer(); ?>