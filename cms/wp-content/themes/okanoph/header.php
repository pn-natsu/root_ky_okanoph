<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="/lib/js/swiper/swiper-bundle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <?php $version = filemtime(ROOT . '/lib/css/structure.css'); ?>
  <link rel="stylesheet" href="/lib/css/structure.css?ver=<?php echo $version; ?>">
  <?php
  $domain = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['HTTP_HOST'];
  $urlall = $domain . $_SERVER["REQUEST_URI"];
  ?>
  <!-- unique css -->
  <?php if (is_front_page()) : ?>
    <?php $version = filemtime(ROOT . '/lib/css/top.css'); ?>
    <link rel="stylesheet" href="/lib/css/top.css?ver=<?php echo $version; ?>">
  <?php else : ?>
    <?php
    if (empty($_SERVER["HTTPS"])) {
      $home_url = str_replace('https://', 'http://', home_url());
    } else {
      $home_url = home_url();
    }
    $serverRoot =  explode($home_url, $urlall);
    if (isset($serverRoot[1])) {
      $urlsplit = explode("/", $serverRoot[1]);
    }
    $target_category = $urlsplit[1];
    if ($target_category != '') :
      $lower_slug = preg_replace('/\.html|\?.*/', "", $target_category);
      $lower_slug_path = ROOT . '/lib/css/' . $lower_slug . '.css';
      if (file_exists($lower_slug_path)) :
        $version = filemtime($lower_slug_path);
    ?>
        <link rel="stylesheet" href="/lib/css/<?php echo $lower_slug ?>.css?ver=<?php echo $version; ?>">
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?>
  <!-- end unique css -->
  <?php
  $title = wp_get_document_title();
  $description = get_bloginfo('description');
  $og_image_default = $domain . '/lib/img/ogp.webp';

  if (function_exists('get_field')) {
    if (get_field('description')) {
      $description = get_field('description');
    }
    if (get_field('og_image')) {
      $og_image_default = get_field('og_image');
    }
  }
  ?>
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- ogp -->
  <meta property="og:locale" content="ja_JP" />
  <meta property="og:title" content="<?php echo $title; ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo $urlall; ?>">
  <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
  <meta property="og:description" content="<?php echo $description; ?>">
  <?php

  global $post;
  if (isset($post)) {
    $str = $post->post_content;
  }
  $searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
  if (is_single()) {
    if (has_post_thumbnail()) {
      $image_id = get_post_thumbnail_id();
      $image = wp_get_attachment_image_src($image_id, 'full');
      $og_image = $image[0];
    } else if (preg_match($searchPattern, $str, $imgurl) && !is_archive()) {
      $og_image = $imgurl[2];
    } else {
      $og_image = $og_image_default;
    }
  } else {
    $og_image = $og_image_default;
  }
  ?>
  <meta property="og:image" content="<?php echo $og_image; ?>">
  <!-- end ogp -->
  <!-- tiwitter card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="<?php bloginfo('name'); ?>">
  <meta name="twitter:title" content="<?php echo $title; ?>">
  <meta name="twitter:description" content="<?php echo $description; ?>">
  <meta name="twitter:image" content="<?php echo $og_image; ?>" />
  <meta itemprop="image" content="<?php echo $og_image; ?>" />
  <!-- end tiwitter card -->
  <link rel="shortcut icon" href="/lib/img/favicon.ico">
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Pharmacy",
      "@id": "https://example.com/#pharmacy",
      "name": "オカノ薬局",
      "url": "https://www.okano-ph.jp/",
      "hasPart": [{
          "@type": "Pharmacy",
          "@id": "https://www.okano-ph.jp/store/papios-higashi/#pharmacy",
          "name": "オカノ薬局 パピオス東店",
          "address": {
            "@type": "PostalAddress",
            "postalCode": "673-0891",
            "addressRegion": "兵庫県",
            "addressLocality": "明石市",
            "streetAddress": "大明石町1-6-1 パピオスあかし3階"
          },
          "telephone": "078-915-8555"
        },
        {
          "@type": "Pharmacy",
          "@id": "https://www.okano-ph.jp/store/papios-nishi/#pharmacy",
          "name": "オカノ薬局 パピオス西店",
          "address": {
            "@type": "PostalAddress",
            "postalCode": "673-0891",
            "addressRegion": "兵庫県",
            "addressLocality": "明石市",
            "streetAddress": "大明石町1-6-1パピオスあかし3階"
          },
          "telephone": "078-915-8577"
        },
        {
          "@type": "Pharmacy",
          "@id": "https://www.okano-ph.jp/store/eki-higashi/#pharmacy",
          "name": "オカノ薬局 駅東店",
          "address": {
            "@type": "PostalAddress",
            "postalCode": "673-0886",
            "addressRegion": "兵庫県",
            "addressLocality": "明石市",
            "streetAddress": "東仲ノ町11-30 KTSビル1F"
          },
          "telephone": "078-915-7613"
        },
        {
          "@type": "Pharmacy",
          "@id": "https://www.okano-ph.jp/store/aspia-mae/#pharmacy",
          "name": "オカノ薬局 アスピア前店",
          "address": {
            "@type": "PostalAddress",
            "postalCode": "673-0886",
            "addressRegion": "兵庫県",
            "addressLocality": "明石市",
            "streetAddress": "東仲ノ町10-17"
          },
          "telephone": "078-915-2481"
        },
        {
          "@type": "Pharmacy",
          "@id": "https://www.okano-ph.jp/store/akashi-eki/#pharmacy",
          "name": "オカノ薬局 明石駅店",
          "address": {
            "@type": "PostalAddress",
            "postalCode": "673-0891",
            "addressRegion": "兵庫県",
            "addressLocality": "明石市",
            "streetAddress": "大明石町1丁目3-3"
          },
          "telephone": "078-918-7624"
        }
      ]
    }
  </script>
  <script type="application/ld+json">
    {
      "@context": "http://schema.org",

      <?php echo json_breadcrumb(); ?> "article": {
        "@type": "Article",
        "headline": "<?php echo $title; ?>",
        "description": "<?php echo $description; ?>",
        "url": "<?php echo $urlall; ?>"
      }
    }
  </script>
  <?php wp_head(); ?>
</head>

<body>
  <div id="pageContainer">
  <!-- header -->
  <?php
  include(ROOT . "/lib/inc/header.html");
  ?>
  <!-- /header -->