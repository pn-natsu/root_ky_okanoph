
(function ($) {

$(function () {
  const seamlessSettings = {
    autoplay: true,
    autoplaySpeed: 0,
    speed: 5000,
    cssEase: 'linear',
    slidesToShow: 2,
    centerMode: true,
    centerPadding: '25%',
    arrows: false,
    dots: false,
    pauseOnFocus: false,
    pauseOnHover: false,
    swipe: false,
    responsive: [
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          centerPadding: '25%',
        }
      }
    ]
  };

  $('.headPhoto').attr('dir', 'rtl').slick($.extend({}, seamlessSettings, {
    rtl: true 
  }));

  $('.bottomPhoto').slick(seamlessSettings);
});


// #blog  
$(function () {
  const $slider = $('#blog .blogContainer');
  const breakpoint = window.matchMedia('(max-width: 767px)');
  let isSliderInitialized = false;

  function slickCheck() {
    if (breakpoint.matches) {
      if (!isSliderInitialized) {
        $slider.slick({
          infinite: false, 
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false, 
          arrows: false,
          dots: false
        });
        isSliderInitialized = true;
      }
    } else {
      if (isSliderInitialized) {
        $slider.slick('unslick');
        isSliderInitialized = false;
      }
    }
  }

  slickCheck();

  breakpoint.addEventListener('change', slickCheck);
});

// #storeinfoList
$(function () {
  const $slider = $('#storeinfoList .slider');
  const originalCount = $slider.children().length;

  const $controls = $(`
    <div class="slider-controls">
      <button class="slider-arrow slider-prev"></button>
      <div class="slider-counter">
        <span class="current-num">1</span> / <span class="total-num">${originalCount}</span>
      </div>
      <button class="slider-arrow slider-next"></button>
    </div>
  `);
  $slider.after($controls);
  // --------------------------------------------------------

  function updateSliderClasses(slick, nextRealIndex) {
    const $slides = $(slick.$slider).find('.slick-slide');
    const count = slick.slideCount;

    $slides.removeClass('current previous next');

    const targetIndexes = [
      nextRealIndex - count,
      nextRealIndex,
      nextRealIndex + count
    ];

    targetIndexes.forEach(function(idx) {
      const $targetSlide = $slides.filter('[data-slick-index="' + idx + '"]');
      $targetSlide.addClass('current');
      $targetSlide.prev('.slick-slide').addClass('previous');
      $targetSlide.next('.slick-slide').addClass('next');
    });
  }

  $slider.on('init', function (event, slick) {
    updateSliderClasses(slick, slick.currentSlide);
    $controls.find('.current-num').text(slick.currentSlide + 1);
  });

  $slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
    updateSliderClasses(slick, nextSlide);
    $controls.find('.current-num').text(nextSlide + 1);
  });

  $slider.slick({
    infinite: originalCount > 1,
    speed: 800,
    autoplaySpeed: 3000,
    centerMode: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    centerPadding: '8%',
    variableWidth: false,
    autoplay: true,
    pauseOnHover: true,
    cssEase: 'ease-in-out',
    
    arrows: true,
    prevArrow: $controls.find('.slider-prev'),
    nextArrow: $controls.find('.slider-next'),

    responsive: [
      {
        breakpoint: 1441,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          centerPadding: '15%'
        }
      }
    ]
  });
});


})(jQuery);


// #header .logoをh1に変更
document.addEventListener('DOMContentLoaded', function () {
  const logo = document.querySelector('#header .logo');
  if (!logo) return;

  const link = logo.querySelector('a');
  if (!link) return;

  const img = link.querySelector('img');
  if (!img) return;

  const h1 = document.createElement('h1');
  h1.className = 'site-title';

  link.replaceWith(h1);
  h1.appendChild(img);
});
