

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
      $('html, body').scrollTop(0);

      setTimeout(function () {
        smoothScroll($target);
      }, 100);
    }
  }

});





  //header
  $(function () {

    $('.btn_menu').on('click', function () {
      $('body').toggleClass('js-menuOpen');
    })

  });

  //clone
    $('#header .gnav').clone().insertBefore('#menu .serviceContainer');
    $('#modal_services .storelist_list').clone().insertAfter('#menu .serviceContainer h2');
    $('#header .recruit').clone().appendTo('#menu .drawerbox');
    $('#footer .otherLinks').clone().appendTo('#menu .drawerbox');
    $('#header .gnav').clone().prependTo('#footer footer');


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
    const $footer = $('footer');

    function updatePagetop() {
      const scrollTop = $win.scrollTop();
      const windowHeight = $win.height();
      const footerTop = $footer.offset().top;

      // 表示・非表示
      if (scrollTop > 300) {
        $pagetop.fadeIn();
      } else {
        $pagetop.fadeOut();
      }

      // 位置調整
      if (window.matchMedia("(max-width: 767px)").matches) {
        $pagetop.css('bottom', '10px');
        return;
      }

      if (scrollTop + windowHeight > footerTop) {
        const offset = (scrollTop + windowHeight) - footerTop;
        $pagetop.css('bottom', offset + 30 + 'px');
      } else {
        $pagetop.css('bottom', '10px');
      }
    }

    $win.on('scroll resize', updatePagetop);
  });

// スクロールバー生成


$(function () {
  const swiper01 = new Swiper("#swiper", {
    loop: false,
    speed: 600,
  slidesPerView: "auto",
  spaceBetween: 16,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    scrollbar: {
      el: ".swiper-scrollbar",
      hide: false,
      draggable: true,
    },

    breakpoints: {
      0: {
        spaceBetween: 30,
      },
      768: {
        
        spaceBetween: 20,
      },
      1024: {
        spaceBetween: 32,
      },
    },
  });
});

// accordion

$(function () {
  $('.openswitch').each(function () {
    const $h2 = $(this);
    const $list = $h2.next('.list');

    if ($list.length === 0) return;

    $h2.on('click', function () {
      $h2.toggleClass('active');
      $list.slideToggle(200);
    });
  });
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




