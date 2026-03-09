<?php get_header(); ?>
<!-- single.php -->
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
    <?php if (have_posts()) :  while (have_posts()) :  the_post(); ?>
        <!-- newsentry -->
        <section class="newsEntry">
          <hgroup>
            <p class="date"><?php the_time('Y/m/d'); ?></p>
            <h2><?php the_title(); ?></h2>
          </hgroup>

          <div class="entryBody">
            <?php the_content(); ?>
          </div>

        </section>
    <?php endwhile;
    endif; ?>

  </main>
  <?php

  $referer = wp_get_referer();
  $archive_url = home_url();
  $archive_url = untrailingslashit($archive_url);
  $back_url = '';
  if ($referer && strpos($referer, $archive_url) !== false) {
    $back_url = 'javascript:history.back();';
  } else {
    $back_url = $archive_url;
  }

  $page = get_page_by_path('news/indexlist');
  if ($page) {
    $list_url = get_permalink($page->ID);
  } else {
    $list_url = get_post_type_archive_link('post');
  }
  ?>

  <div class="backindex">
    <ul>
      <li><a href="<?php echo $back_url; ?>">前のページに戻る</a></li>
      <li><a href="<?php echo $list_url; ?>">お知らせ一覧</a></li>
    </ul>
  </div>
</div>

<?php get_footer(); ?>