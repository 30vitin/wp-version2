/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */
( function( $ ) {
	"use strict";
	var _body    = $( 'body' ),
		_window = $( window );

	$(document).ready(function() {

		$(".goto-checkout").on( 'click', function(e) {

			window.location.href="/checkout"
		})


		_filter_ajax_sort_count();
		_sticky_menu();	
		// Search toggle.
		_search_toggle();
		/*Menu Categories*/
		_categories_menu_toggle();
		//Check to see if the window is top if not then display button
		_back_to_top();
		/* Add button show / hide for widget_product_categories */
		_toggle_categories();
		_event_single_image();
		_toggle_post_detail();
		_tongle_menu();
		_click_thumb_countdown();
		_event_ajax_search();
	});

	_window.resize(function() {
		_load_canvas_menu();
		_resize_sticky_kit();
		_tongle_menu();
	});	
	
	/* Show/hide NewsLetter Popup */
	_window.load(function() {
		_body.addClass('loaded');
		$( ".slick-carousel" ).each(function() {
			_load_slick_carousel($(this));	
		});
	});
	
	function _tongle_menu(){
		var wd_width = _window.width();
		var $menu_sidebar = $("#menu-main-menu",".home-sidebar");
		//Menu Left
		var $menu_left = $("#menu-main-menu",".header-v10");
		appendGrower($menu_left);
		//Menu Left
		if(wd_width > 991)
		{
			offtogglemegamenu($menu_sidebar);
		}else{
			appendGrower($menu_sidebar);
		}	
	}
	
	function _filter_ajax_sort_count(){
		if(!$('.bwp-filter-ajax').length){
			$( ".sort-count" ).change(function() {
				var value = $(this).val();
				_setGetParameter('product_count',value);
			});
		}		
	}
	
	function _resize_sticky_kit(){
		if($(".bwp-single-product").length){
			var $element = $(".bwp-single-product");
			var _data = $element.data();
			if(_data.product_layout_thumb == "list" || _data.product_layout_thumb == "list2"){
				_sticky_kit();
			}
		}		
	}
	
	function _toggle_categories(){
		var $root = $(".widget_product_categories");
		if($(".current-cat-parent",$root).length > 0){
			var $current_parent = $(".current-cat-parent",$root);
			$current_parent.addClass('open');
			$("> .children",$current_parent).stop().slideToggle(400);
		}
		var $current = $(".current-cat",$root);
		$current.addClass('open');
		$("> .children",$current).stop().slideToggle(400);
		
		$( '.cat-parent',$root ).each(function(index) {
			var $element = $(this);
			if($(".children",$element).length > 0){
				$element.prepend('<span class="arrow"></span>');
				$(".arrow",$element).on( 'click', function(e) {
					e.preventDefault();
					$element.toggleClass('open').find( '> .children' ).stop().slideToggle(400);
				});
			}
		});
	}	
	
	function _back_to_top(){
	   _window.scroll(function() {
			if ($(this).scrollTop() > 100) {
				$('.back-top').addClass('button-show');
			} else {
				$('.back-top').removeClass('button-show');
			}
		});

		$('.back-top').on( "click", function() {
			$('html, body').animate({
				scrollTop: 0
			}, 800);
			return false;
		});			
	}	
	
	function _categories_menu_toggle(){
		if($('.categories-menu .btn-categories').length){
			$('.categories-menu .btn-categories').on( "click", function(){
				$('.wrapper-categories').toggleClass('bwp-active');
			});
		}			
	}	
	
	function _search_toggle(){
		$( '.search-toggle' ).on( 'click.break', function( event ) {
			$('.page-wrapper').toggleClass('opacity-style');
			var wrapper = $( '.search-overlay' );
				wrapper.toggleClass( 'search-visible' );
		} );
		$( '.close-search','.search-overlay' ).on( 'click.break', function( event ) {
			$('.page-wrapper').toggleClass('opacity-style');
			var wrapper = $( '.search-overlay' );
				wrapper.toggleClass( 'search-visible');
		} );
	}

	function _show_homepage_sidebar(){
		var $homepage_sidebar = $('.sidebar-homepage .home-sidebar');
		var $main_sidebar = $('.sidebar-homepage .main-sidebar');
		$('.sidebar-homepage .btn-sidebar').on( "click", function() {
			if($homepage_sidebar.hasClass('active')){
				$homepage_sidebar.removeClass('active');
				$main_sidebar.removeClass('active');
			}
			else{
				$homepage_sidebar.addClass('active');
				$main_sidebar.addClass('active');
			}	
			return false;
		});			
	}

	_show_homepage_sidebar();	

	function _wpbingo_menu_left(){
		//Navigation Right
		var $header_wpbingo_menu_left = $('.header-wpbingo-menu-left');
		$('.wpbingo-menu-left .menu-title').on( "click", function() {
			if($header_wpbingo_menu_left.hasClass('active')){
				$header_wpbingo_menu_left.removeClass('active');
			}	
			else{
				$header_wpbingo_menu_left.addClass('active');
			}	
			return false;
		});			
	}

	_wpbingo_menu_left();

	function _canvasLeftNavigation(){
		//Navigation Right
		var $fashow_container_left = $('.fashow_container_left');
		$('.navigation-left').on( "click", function() {
			if($fashow_container_left.hasClass('active')){
				$fashow_container_left.removeClass('active');
				$('.fashow-container-popup').removeClass('active');
			}	
			else{
				$fashow_container_left.addClass('active');
				$('.fashow-container-popup').addClass('active');
			}	
			return false;
		});	

		$('.fashow_close i',$fashow_container_left).on( "click", function() {
			$fashow_container_left.removeClass('active');
			$('.fashow-container-popup').removeClass('active');
			return false;
		});
		
		$('.fashow-container-popup').on( "click", function() {
			$fashow_container_left.removeClass('active');
			$('.fashow-container-popup').removeClass('active');
			return false;
		});	
	
	}

	_canvasLeftNavigation();	

	function _canvasRightNavigation(){
		//Navigation Right
		var $fashow_container_right = $('.fashow_container_right');
		$('.navigation-right').on( "click", function() {
			if($fashow_container_right.hasClass('active')){
				$fashow_container_right.removeClass('active');
				$('.fashow-container-popup').removeClass('active');
			}	
			else{
				$fashow_container_right.addClass('active');
				$('.fashow-container-popup').addClass('active');
			}	
			return false;
		});	

		$('.fashow_close i',$fashow_container_right).on( "click", function() {
			$fashow_container_right.removeClass('active');
			$('.fashow-container-popup').removeClass('active');
			return false;
		});
		
		$('.fashow-container-popup').on( "click", function() {
			$fashow_container_right.removeClass('active');
			$('.fashow-container-popup').removeClass('active');
			return false;
		});	
	
	}

	_canvasRightNavigation();	

	function _setGetParameter(paramName, paramValue)
	{
		var url = window.location.href;
		var hash = location.hash;
		url = url.replace(hash, '');
		if (url.indexOf(paramName + "=") >= 0)
		{
			var prefix = url.substring(0, url.indexOf(paramName));
			var suffix = url.substring(url.indexOf(paramName));
			suffix = suffix.substring(suffix.indexOf("=") + 1);
			suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
			url = prefix + paramName + "=" + paramValue + suffix;
		}
		else
		{
		if (url.indexOf("?") < 0)
			url += "?" + paramName + "=" + paramValue;
		else
			url += "&" + paramName + "=" + paramValue;
		}
		window.location.href = url + hash;
	}
	
	function _sticky_menu(){
		if(_window.width() >= 1024){
			if($(".header-content").data("sticky_header")){
				var CurrentScroll = 0;
				var bwp_width = _window.width();
				_window.scroll(function() {
				if(($(".header-content").data("sticky_tablet") == 0) && bwp_width < 992)
					return;
				var NextScroll = $(this).scrollTop();
					
				if ((NextScroll ) /* < CurrentScroll) && NextScroll*/ >= 0) {
					//$('.bwp-header').addClass('sticky');
				} else if (/*NextScroll >= CurrentScroll || */ NextScroll <=1 ) {
					//$('.bwp-header').removeClass('sticky');
					//console.log('estaaba quitando',NextScroll)
				}

				CurrentScroll = NextScroll;  
				});
			}
		}	
	}	

	function _fashow_top_link(){
		var custom_menu = $('.block-top-link .widget-custom-menu');
		$('.widget-title',custom_menu).on( "click", function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$('div',$(this).parent()).slideUp();	
			}
			else{
				$('.widget-title',custom_menu).removeClass('active');
				$('div',custom_menu).slideUp();				
				$(this).addClass('active');
				$('div',$(this).parent()).slideDown();	
			}	
		});
	}

	_fashow_top_link();
	
	function _load_slick_carousel($element){
		$element.slick({
			arrows: $element.data("nav") ? true : false ,
			dots: $element.data("dots") ? true : false ,
			prevArrow: '<i class="slick-arrow ion ion-ios-arrow-left"></i>',
			nextArrow: '<i class="slick-arrow ion ion-ios-arrow-right"></i>',	
			slidesToShow: $element.data("columns"),
			asNavFor: $element.data("asnavfor") ? $element.data("asnavfor") : false ,
			vertical: $element.data("vertical") ? true : false ,
			verticalSwiping: $element.data("verticalswiping") ? $element.data("verticalswiping") : false ,
			rtl: (_body.hasClass("rtl") && !$element.data("vertical")) ? true : false ,
			centerMode: $element.data("centermode") ? $element.data("centermode") : false ,
			centerPadding: $element.data("centerpadding") ? $element.data("centerpadding") : false ,
			focusOnSelect: $element.data("focusonselect") ? $element.data("focusonselect") : false ,
			responsive: [	
				{
				  breakpoint: 1200,
				  settings: {
					slidesToShow: $element.data("columns1"),
				  }
				},				
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: $element.data("columns2"),
					centerMode : false
				  }
				},
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: $element.data("columns3"),
					vertical: false,
					verticalSwiping : false,
					centerMode : false
				  }
				},
				{
				  breakpoint: 480,			  
				  settings: {
					slidesToShow: $element.data("columns4"),
					vertical: false,
					verticalSwiping : false,
					centerMode : false					
				  }
				}
			],
			onAfterChange: function() {
				_move_nav_slick($element);
			}			
		});
		
		_move_nav_slick($element);
	}
	
	function _move_nav_slick($element){
		if($(".slick-arrow",$element).length > 0){
			var $prev = $(".ion-ios-arrow-left",$element).clone();
			$(".ion-ios-arrow-left",$element).remove();
			if($element.parent().find(".ion-ios-arrow-left").length == 0){
				$prev.prependTo($element.parent());
			}
			$prev.on( "click", function() {
				$element.slickPrev();
			});
			
			var $next =  $(".ion-ios-arrow-right",$element).clone();
			$(".ion-ios-arrow-right",$element).remove();
			if($element.parent().find(".ion-ios-arrow-right").length == 0){
				$next.appendTo($element.parent());
			}
			$next.on( "click", function() {
				$element.slickNext();
			});
		}
		
		if($element.hasClass("content-category") && $element.hasClass("slider")){
			var width_element = $(".item",$element).width();
			$(".item",$element).css("height", width_element);
		}	
	}	
	
	//Dropdown Menu
	function _dropdown_menu(){
		$( ".pwb-dropdown" ).each(function(){
			var $dropdown = $(this);
			var active_text = $dropdown.find('li.active').text();
			$(".pwb-dropdown-toggle",$dropdown).html(active_text);
			$("li",$dropdown).on( "click", function() {
				$("li",$dropdown).removeClass("active");
				$(this).addClass('active');
				var this_text = $(this).text();
				$(".pwb-dropdown-toggle",$dropdown).html(this_text);
				$dropdown.removeClass("open");
			});
		});		
	} 

	_dropdown_menu();
	
	function _click_toggle_filter(){
		var $element = $(".bwp-top-bar");
		$(".button-filter-toggle",$element).on( "click", function() {
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(".sidebar-product-filter").slideUp();
			}else{
				$(this).addClass('active');	
				$(".sidebar-product-filter").slideDown();
			}
		});	
	}
	
	_click_toggle_filter();
	
	//Menu CanVas
	function _click_button_canvas_menu(){
		$('#show-megamenu').on( "click", function() {
			if($('.bwp-canvas-navigation').hasClass('active'))
				$('.bwp-canvas-navigation').removeClass('active');
			else
				$('.bwp-canvas-navigation').addClass('active');
			return false;
		});		
	}
	
	_click_button_canvas_menu();
	
	function _load_canvas_menu(){
		var wd_width = _window.width(); 
		var $main_menu = $(".menu","#main-navigation");
		if(wd_width <= 991){
			if($("#canvas-main-menu").length < 1 && $main_menu.length > 0){
				var $menu = $main_menu.parent().clone();
				$menu.attr( "id", "canvas-main-menu");
				$($menu).find(".menu").removeAttr('id');
				$('#page').append('<div  class="bwp-canvas-navigation"><span id="remove-megamenu" class="remove-megamenu icon-remove"></span></div>');			
				$('.bwp-canvas-navigation').append($menu);
				$menu.mmenu({
					offCanvas: false,
					"navbar": {
					"title": false
					}
				});
				_remove_canvas_menu();
			}
		}else{
			$(".bwp-canvas-navigation").remove();
		}		
	}
	
	_load_canvas_menu();
	
	function _remove_canvas_menu(){
		$('#remove-megamenu').on( "click", function() {
			$('.bwp-canvas-navigation').removeClass('active');
			return false;
		});		
	}

	function _event_single_image(){
		if($(".bwp-single-product").length){
			var $element = $(".bwp-single-product");
			var _data = $element.data();
			if(_data.product_layout_thumb == "zoom"){
				$('.variations_form').on('wc_variation_form show_variation reset_image', function() {
					$('.zoomContainer .zoomWindowContainer .zoomWindow').css('background-image', 'url(' + $('#image').attr('src') + ')');
				});
				if($("#image").length){
					_zoomSingleImage(_data);
				}
			}
			if(_data.product_layout_thumb == "scroll"){
				$('.variations_form').on('wc_variation_form show_variation reset_image', function() {
					$( '.image-thumbnail' ).slickGoTo( 0 );
				});
				$('.img-thumbnail a').bind("click", function(e) {
					e.preventDefault();	
					var obj = [];
					$('.img-thumbnail','.image-additional').each(function(index) {
						var $href = $("a",$(this)).attr("href");
						if($href){
							obj[index] = {"href":$href};
						}
					});
					$.swipebox(obj);
				});
			}
			if(_data.product_layout_thumb == "list" || _data.product_layout_thumb == "list2"){
				$('.img-thumbnail a').bind("click", function(e) {
					e.preventDefault();	
					var obj = [];
					$('.img-thumbnail').each(function(index) {
						var $href = $("a",$(this)).attr("href");
						if($href){
							obj[index] = {"href":$href};
						}
					});
					$.swipebox(obj);
				});
				$('.variations_form').on('wc_variation_form show_variation reset_image', function() {
					$(window).scrollTop( 300 );
				});
			}	
		}
	}
	
	function _zoomSingleImage(_data){
		if (($(window).width()) >= 768){
			$("#image").elevateZoom({
					zoomType : _data.zoomtype,
					scrollZoom  : _data.zoom_scroll,
					lensSize    : _data.lenssize,
					lensShape    : _data.lensshape,
					containLensZoom  : _data.zoom_contain_lens,
					gallery:'image-thumbnail',
					cursor: 'crosshair',
					galleryActiveClass: "active",
					lensBorder: _data.lensborder,
					borderSize : _data.bordersize,
					borderColour : _data.bordercolour,
			});
		}
		else{
			$("#image").elevateZoom({
					zoomEnabled: false,
					scrollZoom: false,
					gallery:'image-thumbnail',
					cursor: 'crosshair',
					galleryActiveClass: "active"
			});
		}
		
		if(_data.popup) {
			$("#image").bind("click", function(e) {
				e.preventDefault();	
				var ez =   $('#image').data('elevateZoom');
				$.swipebox(ez.getGalleryList());
			});		
		}else{
			$("#image").bind("click", function(e) {  
				return false;
			});				
		}		
	}

	function _sticky_kit(){
		var window_width = $( window ).width();
		$(".bwp-single-info").trigger("sticky_kit:detach");
		if (window_width <= 991) {
			$(".bwp-single-product").removeClass("active");
		} else {
			if(($(".bwp-single-info").height()) <= ($(".bwp-single-image").height())){
				$(".bwp-single-product").addClass("active");
				$(".bwp-single-info").stick_in_parent();
			}else{
				$(".bwp-single-product").removeClass("active");
			}
		}		
	}	
	
	function _toggle_post_detail(){
		$(".bwp-recent-post").each(function(){
			var $element = $(this);
			$(".show-more",$element).on( "click", function(){
				if($(this).closest(".post-content").hasClass("active")){
					$(this).closest(".post-content").removeClass("active");
				}else{
					$(this).closest(".post-content").addClass("active");
				}
			});
		});
	}
	
	function appendGrower($menu)
	{
		if($("li.menu-item-has-children",$menu).find('.grower').length <= 0){
			$("li.menu-item-has-children",$menu).append('<span class="grower close"> </span>');
			clickGrower($menu);
		}	
	}
		
	function removeGrower($menu)
	{
		$(".grower",$menu).remove();
	}
	
	function offtogglemegamenu($menu)
	{
		$('li.menu-item-has-children .sub-menu',$menu).css('display','');	
		$menu.removeClass('active');
		$("li.menu-item-has-children  .grower",$menu).removeClass('open').addClass('close');	
	}	
	
	function clickGrower($menu){
		$("li.menu-item-has-children  .grower",$menu).on( "click", function() {
			if($(this).hasClass('close')){
				$(this).addClass('open').removeClass('close');
				$('.sub-menu',$(this).parent()).first().slideDown();			
			}else{
				$(this).addClass('close').removeClass('open');		
				$('.sub-menu',$(this).parent()).first().slideUp();			
			}
		});			
	}
	
	function _click_thumb_countdown($menu)
	{
		var $element = $(".bwp-countdown.default");
		$(".attachment-shop_catalog",$element).on( "click", function() {
			var $src = $(this).attr("src");
			$(this).closest(".item-product").find(".single-image-countdown").attr("src",$src);
		});
	}
	
	/*Search JS*/
	function _event_ajax_search(){
		var $element = $(".ajax-search");
		$(".input-search",$element).on("keydown", function() {
			setTimeout(function($e){	
			var character = $e.val();
			var limit = $element.data("limit") ? $element.data("limit") : 5;
			if(character.length >= 2){
				$( ".result-search-products",$element ).empty();
				$( ".result-search-products",$element ).addClass("loading");
				$( ".result-search-products",$element ).show();
				$.ajax({
					url: $element.data("admin"),
					dataType: 'json',
					data: {
						action : "fashow_search_products_ajax",
						character : character,
						limit : limit
					},
					success: function(json) {
						var html = '';
						if (json.length) {
							for (var i = 0; i < json.length; i++) {
								if (!json[i]['category']) {
									html += '<li class="item-search">';
									html += '	<a class="item-image" href="' + json[i]['link'] + '"><img class="pull-left" src="' + json[i]['image'] + '"></a>';
									character = (character).toLowerCase(character);
									character = (character).replace("%20"," ");
									json[i]['name'] = (json[i]['name']).toLowerCase(json[i]['name']);
									json[i]['name'] = (json[i]['name']).replace(character, '<b>'+character+'</b>');
									html += '<div class="item-content">';
									html += '<a href="' + json[i]['link'] + '" title="' + json[i]['name'] + '"><span>'	+ json[i]['name'] + '</span></a>';
									if(json[i]['price']){
										html += '<div class="price">'+json[i]['price']+'</div>';
									}
									html += '</div></li>';
								}
							}
						}else{	      ///// results
							html = '<li class="no-result-item">'+$element.data("noresult")+'</li>';
						}
						$( ".result-search-products",$element ).removeClass("loading");
						$( ".result-search-products",$element ).html(html);
					}
				});
			}else{
				$( ".result-search-products",$element ).removeClass("loading");
				$( ".result-search-products",$element ).empty();
				$( ".result-search-products",$element ).hide();
			}				
		  }, 200, $(this));
		});	
	}	
	
} )( jQuery );
