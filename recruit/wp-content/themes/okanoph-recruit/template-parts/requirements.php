<?php
$terms = get_terms('job');
if (! empty($terms) && ! is_wp_error($terms)) :
?>
  <section id="requirements">
    <h2>募集職種</h2>
    <div class="requirementsList">
      <?php foreach ($terms as $term):
        if ($term->slug === 'clerk') {
          $job_type_name = $term->description;
        } else {
          $job_type_name = $term->name;
        }
      ?>
        <section>
          <h3><?php echo $job_type_name; ?></h3>
          <div class="photo">
            <?php
            $photo = get_field('photo', 'term_' . $term->term_id);
            if ($photo):
            ?>
              <img src="<?php echo $photo; ?>" alt="">
            <?php else: ?>
              <img src="/recruit/lib/img/cmn/no_image.png" alt="">
            <?php endif; ?>
          </div>
          <?php
          $post_type = get_post_type();
          $args = [
            'posts_per_page' => -1,
            'post_type' => 'requirements',
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'tax_query' => [
              [
                'taxonomy' => 'job',
                'field'    => 'slug',
                'terms'    => $term->slug,
              ],
            ],
          ];
          $query = new WP_Query($args);
          if ($query->have_posts()) :
          ?>
            <dl>
              <?php while ($query->have_posts()) : $query->the_post(); ?>
                <dt><?php echo get_field('job_type'); ?></dt>
                <dd>
                  <?php if (get_field('display')): ?>
                    <a href="<?php the_permalink(); ?>">募集中</a>
                  <?php else: ?>
                    <span>募集なし</span>
                  <?php endif; ?>
                </dd>
              <?php endwhile;
              wp_reset_postdata(); ?>
            </dl>
          <?php endif; ?>
        </section>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>