

(function ($) {
$(function () {

  const $header = $('#header');
  const scrollSpeed = 550;
  let initialScrollTop = 0;

  // 初期表示時のスクロール位置を保存（#pagetop用）
  initialScrollTop = $(window).scrollTop();

  /* スムーススクロール処理 */
  function smoothScroll($target) {
    const headerHeight = $header.outerHeight() || 0;
    const position = $target.offset().top - headerHeight;
    $('html, body')
      .stop(true)
      .animate({ scrollTop: position }, scrollSpeed, 'swing');
  }

  /* ページ内リンククリック */
  $(document).on('click', 'a[href^="#"]', function (e) {
    const href = $(this).attr('href');

    // #pagetop の特別処理
    if (href === '#pagetop') {
      $('html, body')
        .stop(true)
        .animate({ scrollTop: initialScrollTop }, scrollSpeed, 'swing');
      e.preventDefault();
      return;
    }

    const $target = $(href === '#' ? 'html' : href);
    if (!$target.length) return;

    smoothScroll($target);
    e.preventDefault();
  });

  /* 別ページから hash 付き*/
  const urlHash = location.hash;
  if (urlHash) {
    const $target = $(urlHash);

    if ($target.length) {
      // タブ切り替え対象なら active を差し替え
      if ($target.parent('.bodyContainer').length) {
        $('.tab li, .sub_tab li').removeClass('active');
        $(`.tab a[href="${urlHash}"], .sub_tab a[href="${urlHash}"]`)
          .parent()
          .addClass('active');
        $('.bodyContainer > section').removeClass('active');
        $target.addClass('active');
      }

      $('html, body').scrollTop(0);

      setTimeout(function () {
        smoothScroll($target);
      }, 100);
    }
  }

  // カレント表示
  const currentPath = location.pathname
    .replace(/\/index\.html$/, '/')
    .replace(/([^/])$/, '$1/');
  $('#header .gnav a').each(function () {
    const href = $(this).attr('href');
    if (href && currentPath === href) {
      $(this).addClass('current');
    }
  });

  // header fixed
  $(window).on('scroll.headerFixed', function () {
    const wScroll = $(window).scrollTop();
    const headerHeight = $header.outerHeight() || 0;
    if (wScroll > headerHeight) {
      $header.addClass('fixed');
    } else {
      $header.removeClass('fixed');
    }
  });

});



  //clone

    $('#header .gnav').clone().insertAfter('#footer footer .address');
    $('#header .call').clone().appendTo('#fixedfooter');
    $('#header .call, #header .home').each(function () {
      $('<li>').addClass($(this).attr('class')).html($(this).html()).appendTo('#footer .utillink');
    });


  //fadein
  $(window).on('scroll', function () {
    const wHeight = $(window).height();
    const wScroll = $(window).scrollTop();
    const mq_sp = window.matchMedia('screen and (max-width: 767px)');
    let scrForward;
    if (mq_sp.matches) {
      scrForward = 100;
    } else {
      scrForward = 200;
    }
    $(".fadeIn").each(function () {
      const bPosition = $(this).offset().top;
      if (wScroll > bPosition - wHeight + scrForward) {
        $(this).addClass("show");
      }
    });
  });


    
  //modal_open
$(function () {

  // モーダル中央配置
function modalResize($modal) {
  var w = $(window).width();
  var h = $(window).height();

  var maxHeight = h * 0.9; 

  $modal.css({
    maxHeight: maxHeight + 'px',
    overflowY: 'auto'
  });

  var x = (w - $modal.outerWidth(true)) / 2;
  var y = Math.max((h - $modal.outerHeight(true)) / 2, 20);

  $modal.css({
    left: x + 'px',
    top: y + 'px'
  });
}

  // モーダルを開く
  $(document).on('click', '.modal_open', function () {

    var modalId = '#' + $(this).data('target');
    var $modal = $(modalId);

    if (!$('.modal_bg').length) {
      $('body').append('<div class="modal_bg"></div>');
    }

    $('.modal_bg').fadeIn();
    $modal.fadeIn();

    modalResize($modal);

    $(window).off('resize.modal').on('resize.modal', function () {
      modalResize($modal);
    });
  });

  $(document).on('click', '.modal_bg, .modal_close', function () {
    $('.modal_box').fadeOut();
    $('.modal_bg').fadeOut('slow', function () {
      $(this).remove();
    });
    $(window).off('resize.modal');
  });

  $(document).on('click', '.modal_switch', function () {

    var targetId = '#' + $(this).data('target');
    var $targetModal = $(targetId);

    $('.modal_box').fadeOut();
    $targetModal.fadeIn();

    modalResize($targetModal);

    $(window).off('resize.modal').on('resize.modal', function () {
      modalResize($targetModal);
    });
  });

});

  // pagetop

  $(function () {
    const $win = $(window);
    const $pagetop = $('#pagetop');
    const $fixedfooter = $('#fixedfooter');

    function updatePagetop() {
      if ($win.scrollTop() > 300) {
        $pagetop.fadeIn();
      } else {
        $pagetop.fadeOut();
      }

      if (window.matchMedia('(max-width: 767px)').matches) {
        $pagetop.css('bottom', $fixedfooter.outerHeight() + 5 + 'px');
      }
    }

    $win.on('scroll resize', updatePagetop);
    updatePagetop();
  });

// tab for support

$('.tab a, .sub_tab a').on('click', function (e) {
  e.preventDefault();

  const target = $(this).attr('href'); // #sec01 など

  // 両方のタブのactive切り替え
  $('.tab li, .sub_tab li').removeClass('active');
  $(`.tab a[href="${target}"], .sub_tab a[href="${target}"]`)
    .parent()
    .addClass('active');

  // セクションのactive切り替え
  $('.bodyContainer > section').removeClass('active');
  $(target).addClass('active');
});


})(jQuery);


// popupimg
const dialog = document.getElementById('imgDialog');

if (dialog) {
  const dialogImg = dialog.querySelector('img');
  const closeBtn = dialog.querySelector('.close');

  document.querySelectorAll('.js-open-dialog').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      dialogImg.src = link.href;
      dialog.showModal();
    });
  });

  dialog.addEventListener('click', e => {
    if (e.target === dialog) {
      dialog.close();
    }
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      dialog.close();
    });
  }
}




