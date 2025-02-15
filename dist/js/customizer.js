/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	var $style = $('#toocheke-color-scheme-css'),
		api = wp.customize;

	if (!$style.length) {
		$style = $('head').append('<style type="text/css" id="toocheke-color-scheme-css" />')
			.find('#toocheke-color-scheme-css');
	}

	// Site title.
	api('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title').text(to);
		});
	});

	// Site tagline.
	api('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});
	// Footer text.
	api('footer_setting', function (value) {
		value.bind(function (to) {
			$('.footer-info ').text(to);
		});
	});

	//comics header text
	api('latest_comic_setting', function (value) {
		value.bind(function (to) {
			$('#latest-comics-header').text(to);
		});
	});

	//chapters header text
	api('latest_chapter_setting', function (value) {
		value.bind(function (to) {
			$('#latest-chapters-header').text(to);
		});
	});

	//collections header text
	api('latest_collection_setting', function (value) {
		value.bind(function (to) {
			$('#latest-collections-header').text(to);
		});
	});

	//blog posts header text
	api('latest_post_setting', function (value) {
		value.bind(function (to) {
			$('#latest-posts-header').text(to);
		});
	});

	//comic series header text
	api('comic_series_setting', function (value) {
		value.bind(function (to) {
			$('#comic-series-header').text(to);
		});
	});

	// Add nosidebar to body
	api('sidebar_setting', function (value) {
		value.bind(function (to) {
			if (to) {
				$("body").addClass("nosidebar");
			}
			else {
				$("body").removeClass("nosidebar");
			}
		});
	});
	// Home sections
	api('hide_comics_setting', function (value) {
		value.bind(function (to) {
			if (to) {
				$("#comic-archive-list").hide();
			}
			else {
				$("#comic-archive-list").show();
			}
		});
	});
	api('hide_chapters_setting', function (value) {
		value.bind(function (to) {
			if (to) {
				$("#chapter-wrapper").hide();
			}
			else {
				$("#chapter-wrapper").show();
			}
		});
	});
	api('hide_collections_setting', function (value) {
		value.bind(function (to) {
			if (to) {
				$("#collection-wrapper").hide();
			}
			else {
				$("#collection-wrapper").show();
			}
		});
	});
	api('hide_series_setting', function (value) {
		value.bind(function (to) {
			if (to) {
				$("#series-wrapper").hide();
			}
			else {
				$("#series-wrapper").show();
			}
		});
	});
	// Color Scheme CSS.
	api.bind('preview-ready', function () {
		api.preview.bind('update-color-scheme-css', function (css) {
			$style.html(css);
		});
	});

	//jumbotron height...
	api('hero_setting', function (value) {
		value.bind(function (newval) {
			$('.jumbotron').css('height', newval);
		});
	});


})(jQuery);
