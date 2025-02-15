/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'toocheke-color-scheme' ),
		colorSchemeKeys = [
			'background_color',
			'navbar_background_color',
			'jumbotron_and_sidebar_background_color',
			'jumbotron_and_sidebar_text_color',
			'content_background_color',
			'box_text_color',
			'dark_text_color',
			'complementary_color',
			'sidebar_links_active_page_link',
			'active_page_text_color',
			'comic_navbar_link_text_color',
			'main_content_link_color',
			'navbar_link_color',
			'navbar_link_hover_color',
			'footer_background_color',
			'footer_text_color',
			'footer_link_color'
		],
		colorSettings = [
			'background_color',
			'navbar_background_color',
			'jumbotron_and_sidebar_background_color',
			'jumbotron_and_sidebar_text_color',
			'content_background_color',
			'box_text_color',
			'dark_text_color',
			'complementary_color',
			'sidebar_links_active_page_link',
			'active_page_text_color',
			'comic_navbar_link_text_color',
			'main_content_link_color',
			'navbar_link_color',
			'navbar_link_hover_color',
			'footer_background_color',
			'footer_text_color',
			'footer_link_color'
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					// Update Background Color.
					api( 'background_color' ).set( colorScheme[value].colors[0] );
					api.control( 'background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[0] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[0] );

						api( 'navbar_background_color' ).set( colorScheme[value].colors[1] );
						api.control( 'navbar_background_color' ).container.find( '.color-picker-hex' )
							.data( 'data-default-color', colorScheme[value].colors[1] )
							.wpColorPicker( 'defaultColor', colorScheme[value].colors[1] );


					// Update Header/Sidebar Background Color.
					api( 'jumbotron_and_sidebar_background_color' ).set( colorScheme[value].colors[2] );
					api.control( 'jumbotron_and_sidebar_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[2] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[2] );

					// Update Header/Sidebar Text Color.
					api( 'jumbotron_and_sidebar_text_color' ).set( colorScheme[value].colors[3] );
					api.control( 'jumbotron_and_sidebar_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

							// Update Content Background Color.
					api( 'content_background_color' ).set( colorScheme[value].colors[4] );
					api.control( 'content_background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[4] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[4] );


							// Boxed Content Text Color.
					api( 'box_text_color' ).set( colorScheme[value].colors[5] );
					api.control( 'box_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[5] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[5] );


							// Dark Text Color.
					api( 'dark_text_color' ).set( colorScheme[value].colors[6] );
					api.control( 'dark_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[6] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[6] );

							// Complementary Color.
					api( 'complementary_color' ).set( colorScheme[value].colors[7] );
					api.control( 'complementary_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[7] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[7] );

							// Sidebar Links Text Color & And Active Page Link Background Color.
					api( 'sidebar_links_active_page_link' ).set( colorScheme[value].colors[8] );
					api.control( 'sidebar_links_active_page_link' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[8] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[8] );

							// Active Page Link Text Color.
					api( 'active_page_text_color' ).set( colorScheme[value].colors[9] );
					api.control( 'active_page_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[9] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[9] );

							// Comic Navbar Link Text Color.
					api( 'comic_navbar_link_text_color' ).set( colorScheme[value].colors[10] );
					api.control( 'comic_navbar_link_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[10] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[10] );

								// Main Content Link Color.
					api( 'main_content_link_color' ).set( colorScheme[value].colors[11] );
					api.control( 'main_content_link_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[11] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[11] );

											// Navbar Link Color.
					api( 'navbar_link_color' ).set( colorScheme[value].colors[12] );
					api.control( 'navbar_link_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[12] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[12] );

									// Navbar Link Hover Color.
					api( 'navbar_link_hover_color' ).set( colorScheme[value].colors[13] );
					api.control( 'navbar_link_hover_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[13] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[13] );

							// Footer Background Color.
							api( 'footer_background_color' ).set( colorScheme[value].colors[14] );
							api.control( 'footer_background_color' ).container.find( '.color-picker-hex' )
								.data( 'data-default-color', colorScheme[value].colors[14] )
								.wpColorPicker( 'defaultColor', colorScheme[value].colors[14] );

							// Footer Text Color.
					api( 'footer_text_color' ).set( colorScheme[value].colors[15] );
					api.control( 'footer_text_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[15] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[15] );

							// Footer Link Color.
					api( 'footer_link_color' ).set( colorScheme[value].colors[16] );
					api.control( 'footer_link_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[16] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[16] );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(), css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
				colors[ setting ] = api( setting )();
			
		});



		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
