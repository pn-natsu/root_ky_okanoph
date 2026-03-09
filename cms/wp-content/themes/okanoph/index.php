<?php get_header(); ?>
<?php
$post_type = get_post_type();
?>
<!-- index.php -->
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

    $page = get_page_by_path('news/indexlist');
    if ($page) {
      $list_url = get_permalink($page->ID);
    } else {
      $list_url = get_post_type_archive_link('post');
    }
    ?>
    <div class="indexlink"><a href="<?php echo $list_url; ?>">お知らせ一覧</a></div>
    <?php
    $raw_page = filter_input(INPUT_GET, 'pagenum');
    $pagenum = ($raw_page !== null) ? htmlspecialchars($raw_page) : '';
    $paged = (preg_match("/^[0-9]+$/", $pagenum)) ? $pagenum : 1;
    $args = [
      'posts_per_page' => 5,
      'post_type' => $post_type,
      'paged' => $paged,
    ];
    if (isset($term->slug)) {
      $args['category_name'] = $term->slug;
    }
    $query = new WP_Query($args);
    if ($query->have_posts()) :
    ?>
      <?php while ($query->have_posts()) : $query->the_post(); ?>
        <!-- newsentry -->
        <section id="news<?php echo get_the_ID(); ?>" class="newsEntry">
          <hgroup>
            <p class="date"><?php the_time('Y/m/d'); ?></p>
            <h2><?php the_title(); ?></h2>
          </hgroup>

          <div class="entryBody">
            <?php the_content(); ?>
          </div>
        </section>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <?php echo bmPageNavi($query); ?>
    <?php endif;  ?>
  </main>


</div>


<?php get_footer(); ?>