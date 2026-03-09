<?php get_header(); ?>
<!-- 404.php -->
<style>
  .notfound {
    text-align: center;
    padding: 100px 0 !important;
  }

  .notfound p {
    margin-bottom: 20px;
  }
</style>
<div id="contents">
  <div class="notfound">
    <p>ページが見つかりませんでした。</p>
    <p><a href="<?php echo home_url(); ?>">トップへ戻る</a></p>
  </div>
</div>
<?php get_footer(); ?>