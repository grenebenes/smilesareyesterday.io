jQuery(function (jQuery) {

	jQuery('#infinite-scroll').append('<span class="load-more"></span>');
	var button = jQuery('#infinite-scroll .load-more');
	var page = 2;
	var loading = false;
	var scrollHandling = {
		allow: true,
		reallow: function () {
			scrollHandling.allow = true;
		},
		delay: 400 //(milliseconds) adjust to the highest acceptable value
	};
	if(jQuery(button).length){
		jQuery(window).scroll(function () {
	
			if (!loading && scrollHandling.allow) {
				scrollHandling.allow = false;
				setTimeout(scrollHandling.reallow, scrollHandling.delay);
				var offset = jQuery(button).offset().top - jQuery(window).scrollTop();
				if (2000 > offset) {
					jQuery('.load-more').before('<div id="loader-container"><div class="loader"></div></div>');
					loading = true;
					var data = {
						action: 'toocheke_ajax_load_more',
						page: page,
						query: toochekeloadmore.query,
					};
					jQuery.post(toochekeloadmore.url, data, function (res) {
						if (res.success) {
							jQuery('#infinite-scroll').append(res.data);
							jQuery('#infinite-scroll').append(button);
							page = page + 1;
							loading = false;						
						} else {
							// console.log(res);
						}
					}).fail(function (xhr, textStatus, e) {
						// console.log(xhr.responseText);
					});
					jQuery("#loader-container").remove();
	
				}
			}
		});
	}

	
});