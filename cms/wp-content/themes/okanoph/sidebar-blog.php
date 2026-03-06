<div id="side">
      <?php
      $post_type = 'blog';
      $terms = get_terms(array(
        'taxonomy'   => 'blog-cat',
        'hide_empty' => true
      ));
      if (! is_wp_error($terms) && ! empty($terms)) :
      ?>
        <section class="category">
          <h2>カテゴリ</h2>
          <ul class="list">
            <?php foreach ($terms as $term) : ?>
              <li><a href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endif; ?>
      <?php
      $args = [
        'posts_per_page' => 5,
        'post_type' => $post_type,
      ];
      $query = new WP_Query($args);
      if ($query->have_posts()) :
      ?>
        <section class="recent">
          <h2>最新の記事</h2>
          <ul class="list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
              <li><a href="<?php the_permalink(); ?>"><span><?php the_time('Y.m.d'); ?></span><?php the_title(); ?></a></li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          </ul>
        </section>
      <?php endif;  ?>
      <?php
      $show_post_count = true;
      $args = array(
        'post_type' => $post_type, // 投稿タイプ名
        'type' => 'monthly',
        'show_post_count' => true, // 記事件数を表示する
        'echo' => 0,
      );
      $monthlylist = wp_get_archives($args);
      if ($monthlylist):
        $monthlylist = str_replace('/blog/', '/blog/date/', $monthlylist);
      ?>
        <section class="backnumber">
          <h2 class="openswitch">バックナンバー</h2>
          <ul class="list">
            <?php echo $monthlylist; ?>
          </ul>
        </section>
      <?php endif;  ?>
    </div>