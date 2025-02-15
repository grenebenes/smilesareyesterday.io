var url = document.location.href;
var copyLink = document.getElementById('copy-link');
if(copyLink !== null){
  url = copyLink.getAttribute('data-url');
}
var hero = null;
var navbar = null;
var header = null;
var sticky = null;

var checkSwitchedLanguage = readCookie('toocheke-alt-language');



// When the user scrolls the page, execute myFunction
window.onscroll = function () { toochekeAddSticky() };
// Get the hero slider
//hero = document.getElementsByClassName("jumbotron-top")[0];
hero = jQuery(".jumbotron-top:visible")[0];

// Get the navbar
navbar = document.getElementById("site-navigation");
header = document.getElementById("masthead");

// Get the offset position of the navbar
if (navbar) {
  sticky = navbar.offsetTop;
}


// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function toochekeAddSticky() {
  //console.log(hero.offsetHeight);
  //console.log(sticky);
  if (hero) {
    if (window.pageYOffset >= hero.offsetHeight) {
      navbar.classList.add("fixed-top");
      header.classList.add("header-fixed");
    } else {
      navbar.classList.remove("fixed-top");
      header.classList.remove("header-fixed");
    }
  }


}

jQuery(document).ready(function () {
  //handle language switch
  if (checkSwitchedLanguage) {
    jQuery('.fa-language').addClass('fa-inverse');
    jQuery('.default-lang').hide();
    jQuery('.alt-lang').show();

  }
  //handle jumbotron visible
  if (jQuery(".jumbotron").is(":visible")) {
    jQuery(".jumbotron").addClass("jumbotron-visible");
  }
  else {
    jQuery(".jumbotron").removeClass("jumbotron-visible");
  }
  //handle dropdown menu accessiblity
  jQuery(".dropdown-menu .menu-item:last-child").on("focusout", function () {
    jQuery(this).parent(".dropdown-menu").toggle();
  });
  jQuery(".has-submenu").on("focus", function () {
    //jQuery('.dropdown.open .dropdown-toggle').dropdown('toggle');
    jQuery(this).next(".dropdown-menu").toggle();

  });
  var currentIndex = jQuery('.current-comic').data('index');
  /* Carousels */
  jQuery('#collections-carousel').owlCarousel({
    startPosition: currentIndex,
    loop: false,
    margin: 3,
    nav: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 2,
        nav: false
      },
      600: {
        items: 3,
        nav: false
      },
      1000: {
        items: 4,
        nav: false,
        loop: false,
        margin: 3
      }
    }

  });
  jQuery('#comics-carousel').owlCarousel({
    startPosition: currentIndex,
    loop: false,
    margin: 3,
    responsiveClass: true,
    responsive: {
      0: {
        items: 5,
        nav: false
      },
      600: {
        items: 10,
        nav: false
      },
      1000: {
        items: 20,
        nav: false,
        loop: false,
        margin: 3
      }
    }
  });
  //Hide scroll top
  jQuery(window).scroll(function () {
    if (jQuery(document).scrollTop() < 600) {
      jQuery('#home-scroll-container').fadeOut();
    }
    else {
      jQuery('#home-scroll-container').fadeIn();
    }
  });

  //handle language switch
  jQuery(document).on("click", "#switch-language", function () {
    var langCookieLifeSpan = 31;
    if (jQuery('.default-lang').is(":visible")) {
      jQuery('.fa-language').addClass('fa-inverse');
      jQuery('.default-lang').hide();
      jQuery('.alt-lang').show();
      createCookie("toocheke-alt-language", 'Switched language', langCookieLifeSpan);
    }
    else {
      jQuery('.fa-language').removeClass('fa-inverse');
      jQuery('.default-lang').show();
      jQuery('.alt-lang').hide();
      createCookie("toocheke-alt-language", "", -1);
    }
  });

  //Check for empty chapters and collections
  if (!jQuery(".collection-thumbnail")[0]) {
    jQuery("#collection-wrapper").hide();
  }
  if (!jQuery(".chapter-thumbnail")[0]) {
    jQuery("#chapter-wrapper").hide();
  }

  //Handle panel collapse
  jQuery('.panel-collapse').on('show.bs.collapse', function () {
    jQuery(this).siblings('.panel-heading').addClass('active');
  });

  jQuery('.panel-collapse').on('hide.bs.collapse', function () {
    jQuery(this).siblings('.panel-heading').removeClass('active');
  });

  jQuery("#copy-link").on("click", function (e) {
		e.preventDefault();
		navigator.clipboard.writeText(window.location.href);
		this.insertAdjacentHTML('afterend', '<span id="copy-tooltip" data-toggle="tooltip" title="URL copied to clipboard" data-placement="bottom">Link copied</span>'); setTimeout(() => { document.querySelectorAll('#copy-tooltip').forEach(el => el.remove()); }, 3000);
	});

})