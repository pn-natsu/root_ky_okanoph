<?php get_header(); ?>
<!-- single-blog.php -->
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
      <?php if (have_posts()) :  while (have_posts()) :  the_post(); ?>
          <!-- blogentry -->
          <section id="blog20241202" class="entry">
            <hgroup>
              <p class="date"><?php the_time('Y/m/d'); ?></p>
              <h2><?php the_title(); ?></h2>
            </hgroup>

            <div class="entryBody">
              <?php the_content(); ?>
            </div>
          </section>



          <ul class="articleLink">
            <?php previous_post_link('<li class="previous">%link</li>', '前の記事'); ?>
            <?php next_post_link('<li class="next">%link</li>', '次の記事'); ?>
          </ul>
          <div class="backindex"><a href="<?php echo get_post_type_archive_link('blog'); ?>">ブログトップ</a></div>

      <?php endwhile;
      endif; ?>

    </main>
    <?php get_sidebar('blog'); ?>

  </div>



</div>

<?php get_footer(); ?>