<?php

if (!defined('ROOT')) {
  define('ROOT', $_SERVER['DOCUMENT_ROOT']);
}

// 投稿⇒インタビューに名前を変更
function change_post_menu_label()
{
  global $menu;
  global $submenu;
  $menu[5][0] = 'インタビュー';
  $submenu['edit.php'][5][0] = '投稿一覧';
  $submenu['edit.php'][10][0] = '新規追加';
}
function change_post_object_label()
{
  global $wp_post_types;
  $wp_post_types['post']->label = 'インタビュー';
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'インタビュー';
  $labels->singular_name = 'インタビュー';
  $labels->add_new = _x('追加', 'インタビュー');
  $labels->add_new_item = 'インタビューの新規追加';
  $labels->edit_item = 'インタビューの編集';
  $labels->new_item = '新規インタビュー';
  $labels->view_item = 'インタビューを表示';
  $labels->search_items = 'インタビューを検索';
  $labels->not_found = '記事が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
}
add_action('init', 'change_post_object_label');
add_action('admin_menu', 'change_post_menu_label');

//カスタム投稿
add_action('init', 'create_post_type');

function create_post_type()
{

  $cp_data = array(
    array(
      'name' => 'requirements',
      'title' => '募集職種',
      'slug' => 'requirements',
      'category' => array(
        array(
          'cat_name' => 'job',
          'cat_title' => '職種',
        ),
      ),
    ),
  );
  for ($i = 0; $i < count($cp_data); $i++) {
    register_post_type($cp_data[$i]['name'], array(
      "label" => __($cp_data[$i]['title'], ''),
      "labels" => array(
        "name" => __($cp_data[$i]['title'], ''),
        "singular_name" => __($cp_data[$i]['title'], ''),
        "menu_name" => __($cp_data[$i]['title'], ''),
        "all_items" => __('投稿一覧', ''),
        "add_new" => __('新規追加', ''),
        "add_new_item" => __($cp_data[$i]['title'] . ' 新規追加', ''),
        "edit_item" => __('編集', ''),
        "new_item" => __($cp_data[$i]['title'] . ' 編集', ''),
        "view_item" => __('表示', ''),
        "search_items" => __($cp_data[$i]['title'] . 'を検索', ''),
        "not_found" => __('見つかりません', ''),
        "not_found_in_trash" => __('ゴミ箱には見当たりません', ''),
        "parent" => __('親', ''),
      ),
      "description" => "",
      "public" => true,
      "show_ui" => true,
      "show_in_rest" => true,
      "rest_base" => "",
      "has_archive" => true, //falseで、スラッグのURLは固定ページが優先される
      "show_in_menu" => true,
      "exclude_from_search" => false,
      "capability_type" => "post",
      "map_meta_cap" => true,
      "hierarchical" => true,
      "rewrite" => array("slug" => $cp_data[$i]['slug'], "with_front" => false),
      "query_var" => true,
      "menu_position" => 5,
      "supports" => array("title", "editor", 'thumbnail'),
      'yarpp_support' => true,
      //'taxonomies' => $cp_data[$i]['tax'],
    ));

    tax_admin_order($cp_data[$i]['name']);

    if ($cp_data[$i]['category']) {
      for ($j = 0; $j < count($cp_data[$i]['category']); $j++) {
        register_taxonomy(
          $cp_data[$i]['category'][$j]['cat_name'],
          $cp_data[$i]['name'],
          array(
            'hierarchical' => true,
            'update_count_callback' => '_update_post_term_count',
            'label' => $cp_data[$i]['category'][$j]['cat_title'],
            'singular_label' => $cp_data[$i]['category'][$j]['cat_title'],
            'public' => true,
            'show_ui' => true,
            "show_in_rest" => true,
          )
        );
        //if ($cp_data[$i]['name'] === 'web_address') {
        tax_admin_column(
          $cp_data[$i]['name'],
          $cp_data[$i]['category'][$j]['cat_name'],
          $cp_data[$i]['category'][$j]['cat_title']
        );
      }
    }
  }

  //タグ追加
  /*
  register_taxonomy(
    'taxonoomy_xxxx',
    'post_type_xxxx',
    array(
      'hierarchical' => false,
      'update_count_callback' => '_update_post_term_count',
      'label' => 'タグ',
      'singular_label' => 'タグ',
      'public' => true,
      'show_ui' => true,
      "show_in_rest" => true,
    )
  );
  tax_admin_column('post_type_xxxx', 'taxonoomy_xxxx', 'タグ');
  */
}

//タグをチェックボックスに変更するコード（カスタム投稿タイプの投稿画面）
function change_term_to_checkbox()
{
  $args = get_taxonomy('post_type_xxxx'); //カスタム投稿タイプ名
  $args->hierarchical = true; //Gutenberg用
  $args->meta_box_cb = 'post_categories_meta_box';
  register_taxonomy('taxonomy_xxxx', 'post_type_xxxx', $args); //カスタムタクソノミー名、カスタム投稿タイプ名
}
//add_action('init', 'change_term_to_checkbox', 999);


//タクソノミーを管理画面の列に表示
function tax_admin_column($post_name, $taxonomy, $tax_label)
{
  add_filter('manage_edit-' . $post_name . '_columns', function ($columns) use ($post_name, $taxonomy, $tax_label) {
    $columns[$taxonomy] = $tax_label;
    return $columns;
  });
  add_action('manage_' . $post_name . '_posts_custom_column', function ($column_name, $post_id) use ($post_name, $taxonomy, $tax_label) {
    if ($column_name == $taxonomy) {
      $tax = wp_get_object_terms($post_id, $taxonomy);
    }
    if (!empty($tax)) {
      $tax_names = array();
      foreach ($tax as $tit) {
        if ($tit->slug === 'casestudy') {
          continue;
        }
        $tax_names[] = $tit->name;
      }
      echo implode('、', $tax_names);
    }
  }, 10, 2);
  add_action('restrict_manage_posts', function () use ($post_name, $taxonomy, $tax_label) {
    global $post_type;
    if ($post_type == $post_name) {
?>
      <select name="<?php echo $taxonomy; ?>">
        <option value=""><?php echo $tax_label; ?>指定なし</option>
        <?php $terms = get_terms($taxonomy);
        foreach ($terms as $term) : ?>
          <option value="<?php echo $term->slug; ?>" <?php if ($_GET[$taxonomy] == $term->slug) {
                                                        print 'selected';
                                                      } ?>><?php echo $term->name; ?></option>
        <?php endforeach; ?>
      </select>
  <?php
    }
  });
}

//カスタム投稿を日付順に表示
function tax_admin_order($post_name)
{
  add_filter('pre_get_posts', function ($wp_query) use ($post_name) {
    if (is_admin()) {
      if ($wp_query->query['post_type'] == $post_name) {
        $wp_query->set('orderby', 'date');
        $wp_query->set('order', 'DESC');
      }
    }
  });
}



// アイキャッチを有効化
add_theme_support('post-thumbnails');

// 記事内の画像を取得
function catch_that_image()
{
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all("/<img[^>]+src=[\"'](s?https?:\/\/[\-_\.!~\*'()a-z0-9;\/\?:@&=\+\$,%#]+\.(jpg|jpeg|png|gif))[\"'][^>]+>/i", $post->post_content, $matches);
  if (isset($matches[1][0])) {
    $first_img = $matches[1][0];
  }
  return $first_img;
}

//パーマリンクカテゴリ削除
add_filter('user_trailingslashit', 'remcat_function');
function remcat_function($link)
{
  return str_replace("/category/", "/", $link);
}
add_action('init', 'remcat_flush_rules');
function remcat_flush_rules()
{
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_filter('generate_rewrite_rules', 'remcat_rewrite');
function remcat_rewrite($wp_rewrite)
{
  $new_rules = array('(.+)/page/(.+)/?' => 'index.php?category_name=' . $wp_rewrite->preg_index(1) . '&paged=' . $wp_rewrite->preg_index(2));
  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

function get_current_page_slug()
{
  // 現在の投稿IDを取得
  $post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;

  // 投稿IDが無効な場合は処理を終了
  if (!$post_id) {
    return '';
  }

  // 投稿オブジェクトを取得
  $post = get_post($post_id);

  // 投稿オブジェクトからスラッグを取得
  if ($post) {
    return $post->post_name; // スラッグを返す
  }

  return '';
}


// 特定の投稿タイプのみ、ブロックエディタ（Gutenberg）を無効化する
function my_disable_block_editor($use_block_editor, $post_type)
{
  if (in_array($post_type, ['page'], true)) {
    return false;
  }
  return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'my_disable_block_editor', 10, 2);

// 特定の投稿タイプのみ、ビジュアルエディタを無効化する（HTMLエディタのみにする）
function my_disable_visual_editor($can_richedit)
{
  global $post;

  if ($post && in_array(get_post_type($post), ['page'], true)) {
    return false;
  }
  return $can_richedit;
}
add_filter('user_can_richedit', 'my_disable_visual_editor');

//特定のページのみ、エディタを非表示
function custom_action_for_specific_slug()
{
  $slug = get_current_page_slug();

  if ($slug === 'page_slug_xxxx') {
    echo '<style>#postdivrich { display: none; }</style>';
  }
}
add_action('admin_head', 'custom_action_for_specific_slug');

//特定の投稿タイプのみ、編集画面で不要な項目を非表示にする
function my_remove_post_support()
{
  remove_post_type_support('post_type', 'editor');
}
add_action('init', 'my_remove_post_support');




// ショートコード
function include_my_php($atts)
{
  $atts = shortcode_atts(array(
    'file' => ''
  ), $atts, 'myphp');

  if (empty($atts['file'])) {
    return '<p>ファイル名が指定されていません。</p>';
  }

  $base_dir = get_stylesheet_directory();
  $path = str_replace(array('../', '..\\'), '', $atts['file']);
  $template_path = $base_dir . '/' . $path . '.php';
  if (!file_exists($template_path)) {
    return '<p>ファイルが見つかりません: ' . esc_html($path) . '.php</p>';
  }
  ob_start();
  include $template_path;
  return ob_get_clean();
}
add_shortcode('myphp', 'include_my_php');

// 自動pタグ生成をやめる
function customize_auto_p_handling($content)
{
  if (is_page() && !is_front_page()) {
    remove_filter('the_content', 'wpautop');
  }
  return $content;
}
add_filter('the_content', 'customize_auto_p_handling', 0);

//TinyMCE導入時の追加設定
//add_filter( 'tiny_mce_before_init', 'tinymce_init', 100);
function tinymce_init($init)
{
  $init['wpautop'] = false;
  $init['apply_source_formatting'] = true;
  return $init;
}

// タイトル生成

add_theme_support('title-tag');
function change_title_separator($sep)
{
  $sep = '／';
  return $sep;
}
add_filter('document_title_separator', 'change_title_separator');

// ページタイトルを取得
function get_page_title()
{
  $page_title = wp_get_document_title();

  return $page_title;
}

//条件分岐タグ等を使ってページにより $title を変更する処理
function change_title_tag($title)
{

  /*
  $urlall =  (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  if (preg_match("/xxxx/", $urlall)) {
    $title = 'ｘｘｘｘ';
  }
    */

  return $title;
}
add_filter('pre_get_document_title', 'change_title_tag');

add_filter('document_title', function ($title) {
  $title = str_replace(' ｜ ', '｜', $title);
  return $title;
});



// ページネーション

// ページネーション
function bmPageNavi($query = null, $max_page = null)
{
  global $wp_rewrite;
  global $wp_query;
  global $paged;

  $the_query = $query ? $query : $wp_query;

  $paginate_base = get_pagenum_link(1);
  if (strpos($paginate_base, '?') || !$wp_rewrite->using_permalinks()) {
    $paginate_format = '';
    $paginate_base = add_query_arg('pagenum', '%#%');
  } else {
    $paginate_format = (substr($paginate_base, -1, 1) == '/' ? '' : '/') .
      untrailingslashit('?pagenum=%#%', 'pagenum');;
    $paginate_base .= '%_%';
  }

  if ($max_page) {
    $total = $max_page;
  } else {
    $total = $the_query->max_num_pages;
  }

  $result = paginate_links(array(
    'base' => $paginate_base,
    'format' => $paginate_format,
    'total' => $total,
    'mid_size' => 5,
    'current' => ($paged ? $paged : 1),
    'type'  => 'array',
    'prev_text' => '前へ',
    'next_text' => '次へ'
  ));

  if (is_array($result)) {
    $paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');
    echo '<ul class="pager">';
    //echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
    foreach ($result as $page) {
      echo "<li>$page</li>\n";
    }
    echo '</ul>';
  }
}

/* 【出力カスタマイズ】未来の日付の投稿を表示する */
function stop_post_status_future_func($data, $postarr)
{
  if ($data['post_status'] == 'future' && $postarr['post_status'] == 'publish') {
    $data['post_status'] = 'publish';
  }
  return $data;
};
//add_filter('wp_insert_post_data', 'stop_post_status_future_func', 10, 2);

//画像を投稿に挿入する際のタグの変更（Gutenbergでは認識されない）
function give_linked_images_class($html, $id, $caption, $title, $align, $url, $size)
{
  $str_a = '<a href';
  if (strstr($html, $str_a)) {
    $str_a_class = '<a class="pop" href';
    $html = str_replace($str_a, $str_a_class, $html);
    /* //画像にもクラスを追加する場合
    $str_img = '" /></a>';
    $str_img_class = ' bbb" /></a>';
    $html = str_replace($str_img, $str_img_class, $html);
				*/
  }
  return $html;
}

add_action('image_send_to_editor', 'give_linked_images_class', 10, 8);

//カスタム投稿のデフォルトタクソノミーを指定
function default_taxonomy_select()
{
  ?>
  <script type="text/javascript">
    jQuery(function($) {
      //console.log('check');
      //$('#categorychecklist li:first-child input[type="checkbox"]').prop('checked', true);
    });
  </script>
<?php
}
add_action('admin_head-post-new.php', 'default_taxonomy_select');
add_action('admin_head-post.php', 'default_taxonomy_select');
add_action('admin_head-edit.php', 'default_taxonomy_select');

//カテゴリの記事数をリンクに含める
add_filter('wp_list_categories', 'my_list_categories', 10, 2);
function my_list_categories($output, $args)
{
  $output = preg_replace('/<\/a>\s*\((\d+)\)/', ' ($1)</a>', $output);
  return $output;
}

//アーカイブの記事数をリンクに含める
add_filter('get_archives_link', 'my_archives_link');
function my_archives_link($output)
{
  $output = preg_replace('/<\/a>\s*(&nbsp;)\((\d+)\)/', ' ($2)</a>', $output);
  return $output;
}



//srcsetを出力しない
add_filter('wp_calculate_image_srcset_meta', '__return_null');

//デフォルト投稿で不要なカラムを削除
function add_posts_columns($columns)
{
  //unset($columns['categories']);
  unset($columns['comments']);
  unset($columns['tags']);
  return $columns;
}
add_filter('manage_post_posts_columns', 'add_posts_columns');

//投稿一覧のカラムにカスタムフィールドを追加

$add_column_customs = array(
  array(
    'post_type' => 'post',
    'cf_slug' => 'interview_order',
    'cf_name' => '並び順',
  ),
  array(
    'post_type' => 'requirements',
    'cf_slug' => 'job_type',
    'cf_name' => '募集形態',
  ),
);

$job_type_label = array(
  'full-time' => '正社員',
  'part-time' => 'パート',
);

foreach ($add_column_customs as $add_column_custom) {
  // カスタム投稿の一覧に新しい列を追加
  add_filter('manage_' . $add_column_custom['post_type'] . '_posts_columns', function ($columns) use ($add_column_custom) {
    $columns['custom_field_' . $add_column_custom['cf_slug']] = $add_column_custom['cf_name'];
    return $columns;
  });

  // カスタム列にカスタムフィールドの値を表示
  add_action('manage_' . $add_column_custom['post_type'] . '_posts_custom_column', function ($column_name, $post_id) use ($add_column_custom, $job_type_label) {
    if ($column_name === 'custom_field_' . $add_column_custom['cf_slug']) {
      $custom_field = get_post_meta($post_id, $add_column_custom['cf_slug'], true);
      if ($add_column_custom['cf_slug'] === 'pickup') {
        echo $custom_field ? '〇' : '—';
      } else {
        if (isset($job_type_label[$custom_field])) {
          $custom_field = $job_type_label[$custom_field];
        }
        echo $custom_field ? esc_html($custom_field) : '—';
      }
    }
  }, 10, 2);
}


//?pageを勝手に転送しない
add_filter('redirect_canonical', 'my_disable_redirect_canonical');
function my_disable_redirect_canonical($redirect_url)
{

  if (is_page()) {
    $subject = $redirect_url;
    $pattern = '/\?page/'; // URLに「?page」があるかチェック
    preg_match($pattern, $subject, $matches);

    if ($matches) {
      //リクエストURLに「?page」があれば、リダイレクトしない。
      $redirect_url = false;
      return $redirect_url;
    }
  }
}

//投稿本文を任意の文字数で取得
//get_the_custom_excerpt( get_the_content(), 150 )
function get_the_custom_excerpt($content, $length)
{
  $length = ($length ? $length : 70);
  $content =  preg_replace('/<!--more-->.+/is', "", $content);
  $content =  strip_shortcodes($content);
  $content =  strip_tags($content);
  $content =  str_replace(" ", "", $content);
  $content =  mb_substr($content, 0, $length);
  return $content;
}

//自動wpファビコン　オフ
add_action('do_faviconico', 'wp_favicon_remover');
function wp_favicon_remover()
{
  exit;
}

//エディタ用のcssファイルを読み込む
//add_editor_style();

//「JSON-LD」形式のパンくずリストの自動生成関数
function json_breadcrumb()
{

  if (is_admin() || is_home() || is_front_page()) {
    return;
  }

  $position  = 1;
  $query_obj = get_queried_object();
  $permalink = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

  $json_breadcrumb = array(
    "@context"        => "http://schema.org",
    "@type"           => "BreadcrumbList",
    //"name"            => "パンくずリスト",
    "itemListElement" => array(
      array(
        "@type"    => "ListItem",
        "position" => $position++,
        "name" => "トップページ",
        "item" => esc_url(home_url('/'))
      ),
    ),
  );

  if (is_page()) {

    $ancestors   = get_ancestors($query_obj->ID, 'page');
    $ancestors_r = array_reverse($ancestors);
    if (count($ancestors_r) != 0) {
      foreach ($ancestors_r as $key => $ancestor_id) {
        $ancestor_obj = get_post($ancestor_id);
        $json_breadcrumb['itemListElement'][] = array(
          "@type"    => "ListItem",
          "position" => $position++,
          "name" => esc_html($ancestor_obj->post_title),
          "item" => esc_url(get_the_permalink($ancestor_obj->ID))
        );
      }
    }
    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "name" => esc_html($query_obj->post_title),
      "item" => esc_url($permalink)
    );
  } elseif (is_post_type_archive()) {

    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "name" => $query_obj->label,
      "item" => esc_url(get_post_type_archive_link($query_obj->name))
    );
  } elseif (is_tax() || is_category()) {

    if (!is_category()) {
      $post_type = get_taxonomy($query_obj->taxonomy)->object_type[0];
      $pt_obj    = get_post_type_object($post_type);
      $json_breadcrumb['itemListElement'][] = array(
        "@type"    => "ListItem",
        "position" => $position++,
        "name" => $pt_obj->label,
        "item" => esc_url(get_post_type_archive_link($pt_obj->name))
      );
    }

    $ancestors   = get_ancestors($query_obj->term_id, $query_obj->taxonomy);
    $ancestors_r = array_reverse($ancestors);
    foreach ($ancestors_r as $key => $ancestor_id) {
      $json_breadcrumb['itemListElement'][] = array(
        "@type"    => "ListItem",
        "position" => $position++,
        "name" => esc_html(get_cat_name($ancestor_id)),
        "item" => esc_url(get_term_link($ancestor_id, $query_obj->taxonomy))
      );
    }

    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "name" => esc_html($query_obj->name),
      "item" => esc_url(get_term_link($query_obj))
    );
  } elseif (is_single()) {

    if (!is_single('post')) {
      $pt_obj = get_post_type_object($query_obj->post_type);
      $json_breadcrumb['itemListElement'][] = array(
        "@type"    => "ListItem",
        "position" => $position++,
        "name" => esc_html($pt_obj->label),
        "item" => esc_url(get_post_type_archive_link($pt_obj->name))
      );
    }

    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "name" => esc_html($query_obj->post_title),
      "item" => esc_url($permalink)
    );
  } elseif (is_404()) {

    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "name" => "404 Not found",
      "item" => esc_url($permalink)
    );
  } elseif (is_search()) {

    $json_breadcrumb['itemListElement'][] = array(
      "@type"    => "ListItem",
      "position" => $position++,
      "name" => "「" . get_search_query() . "」の検索結果",
      "item" => esc_url($permalink)
    );
  }

  //echo '<script type="application/ld+json">'.json_encode( $json_breadcrumb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ).'</script>';
  return '"breadcrumb": ' . json_encode($json_breadcrumb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . ",";
}
//add_action( 'wp_head', 'json_breadcrumb' );

//検索結果にカスタムフィールドも含める
function filter_search($query)
{
  if ($query->is_search() && $query->is_main_query() && !is_admin()) {
    $post_array = array('page', 'web_policy');
    $contact_confirm = get_page_by_path('contact/confirm')->ID;
    $contact_thanks = get_page_by_path('contact/thanks')->ID;
    $not_in_array = array($contact_confirm, $contact_thanks);
    $query->set('post_type', $post_array);
    $query->set('post__not_in', $not_in_array);
  }
}
add_filter('pre_get_posts', 'filter_search');
//検索
function custom_search($search, $wp_query)
{
  global $wpdb;
  if (!$wp_query->is_search) return $search;
  if (!isset($wp_query->query_vars)) return $search;

  $search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
  if (count($search_words) > 0) {
    $search = '';

    foreach ($search_words as $word) {
      if (!empty($word)) {
        $search_word = '%' . esc_sql($word) . '%';
        $search .= " AND (
  {$wpdb->posts}.post_title LIKE '{$search_word}'
  OR {$wpdb->posts}.post_content LIKE '{$search_word}'
  OR {$wpdb->posts}.ID IN (
  SELECT distinct r.object_id
  FROM {$wpdb->term_relationships} AS r
  INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
  INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
  WHERE t.name LIKE '{$search_word}'
  OR t.slug LIKE '{$search_word}'
  OR tt.description LIKE '{$search_word}'
  )
  OR {$wpdb->posts}.ID IN (
  SELECT distinct post_id
  FROM {$wpdb->postmeta}
  WHERE meta_value LIKE '{$search_word}'
  )
  )";
      }
    }
  }
  return $search;
}
add_filter('posts_search', 'custom_search', 10, 2);

//ビジュアルでspanタグが消えるのを阻止
function my_tiny_mce_before_init($init_array)
{
  $init_array['valid_elements']          = '*[*]';
  $init_array['extended_valid_elements'] = '*[*]';

  return $init_array;
}
add_filter('tiny_mce_before_init', 'my_tiny_mce_before_init');

//アーカイブページで現在のカテゴリー・タグ・タームを取得する
function get_current_term()
{

  $id = '';
  $tax_slug = '';

  if (is_category()) {
    $tax_slug = "category";
    $id = get_query_var('cat');
  } else if (is_tag()) {
    $tax_slug = "post_tag";
    $id = get_query_var('tag_id');
  } else if (is_tax()) {
    $tax_slug = get_query_var('taxonomy');
    $term_slug = get_query_var('term');
    $term = get_term_by("slug", $term_slug, $tax_slug);
    $id = $term->term_id;
  }

  return get_term($id, $tax_slug);
}

// ブロックエディタを完全に無効化
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_widgets_block_editor', '__return_false');
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
  return false;
}, 10, 2);

//ContactForm7の自動pタグ生成を無効
add_filter('wpcf7_autop_or_not', '__return_false');

?>