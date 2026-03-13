<?php get_header(); ?>
<!-- single-requirements.php -->
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
      <p class="sub">募集要項</p>
      <h1 class="pagetitle"><?php the_title(); ?></h1>
      <p class="type"><?php echo get_field('job_type'); ?></p>
    </div>

    <div class="discription">
      <?php if (get_field('lead')) : ?>
        <p class="lead"><?php echo get_field('lead'); ?></p>
      <?php endif; ?>
      <?php if (get_the_content()) : ?>
        <?php the_content(); ?>
      <?php endif; ?>
      <?php if (has_post_thumbnail()) : ?>
        <div class="image"><?php the_post_thumbnail('full'); ?></div>
      <?php endif; ?>
    </div>

    <!-- requirements data -->
    <div id="requirementsData">
      <table cellspacing="0" class="reqtable">
        <tbody>
          <?php
          $job = get_the_terms(get_the_ID(), 'job');
          ?>
          <tr>
            <th scope="col">職種</th>
            <td><?php echo $job[0]->name; ?></td>
          </tr>
          <?php
          $field_objects  = get_field_objects();
          if ($field_objects):
            foreach ($field_objects as $field):
          ?>
              <?php if ($field['value']): ?>
                <tr>
                  <th scope="col"><?php echo $field['label']; ?></th>
                  <td><?php echo $field['value']; ?></td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>


      <div class="entryform_btn"><a href="<?php echo home_url(); ?>/entryform/">エントリーフォームは<br class="sp">こちらから</a></div>


    </div>


  </main>
</div>

<?php get_footer(); ?>