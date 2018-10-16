jQuery(function($) {
	"use strict";

	var cosmos_fn = window.cosmos_fn || {};

	/* Loading page */
	cosmos_fn.hide_loading = function(){
		if ( $('.loading_content').length ) {
			setTimeout(function(){
				$('body').imagesLoaded(function(){
					$('.loading_content').fadeOut(300, function(){
						$(this).hide(1);
					});
				});
			}, 2000);
		}
	};

	/* Init header */
	cosmos_fn.init_header = function(){
		if ( $('.cosmos-header').length ) {
			var offsetMenu = $('.cosmos-header').offset();
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			var offsetMenuTop = offsetMenu.top + $('.cosmos-header').height();
			if ( scrollTop > offsetMenuTop ) {
				$('.blk-menu-fix').addClass('is_scroll');
			} else {
				$('.blk-menu-fix').removeClass('is_scroll');
			}
			if ( $('.menu-mb').length ) {
				if ( $(window).width() > 1325 ) {
					$('.menu-mb').hide();
					$('.blk-menu-fix').attr('style', '');
				}
			}
			setTimeout(function() {
				var height = $('.blk-menu-fix').height();
				$('.page-title-banner').css({
					'padding-top': height
				});
			}, 300);

		}
	};
	cosmos_fn.menu_header = function(){
		if ( $('#nav-toggle').length ) {
			
			$( "#nav-toggle" ).click(function(event){
				event.stopPropagation();
				if($('.menu-mb').hasClass('active-mb')){
					$('.menu-mb').hide();
					$('.menu-mb').removeClass('active-mb');
					$(this).closest('.blk-menu-fix').attr('style', '');
					$('.blk-menu-fix').removeClass('is_open_menu_mb');
				} else {
					$('.menu-mb').show();
					$('.menu-mb').addClass('active-mb');
					$(this).closest('.blk-menu-fix').css({
						'bottom': '0',
						'overflow-y': 'auto'
					});
					$('.blk-menu-fix').addClass('is_open_menu_mb');
				}
			});

			$(document).on('click touchstart', function(e){
				if(!$(e.target).closest('.menu-mb').length && !$(e.target).is('#nav-toggle')){		
					if($('.menu-mb').hasClass('active-mb')){
						$('.menu-mb').hide();
						$('.menu-mb').removeClass('active-mb');
						$('.blk-menu-fix').attr('style', '');
						$('.blk-menu-fix').removeClass('is_open_menu_mb');
						return false;
					}
				}
			});
			
			$('.menu-mb .has-sub-menu .menu__link').click(function(e){
				e.stopPropagation();
				var parent_this = $(this).closest('li');
				if ( parent_this.children(".parent-sub-menu").length == true ) {
					if($(this).hasClass('active-mb')){
						$(this).removeClass('active-mb');
					}else{
						$(this).addClass('active-mb');
					}
					if (parent_this.children(".parent-sub-menu").css("display") == "block") {
					    parent_this.children(".parent-sub-menu").hide();
						return false;
					} else {
					    parent_this.children(".parent-sub-menu").show();
						return false;
					}
				}				
			});

		}
	};

	cosmos_fn.scroll_menu_click = function(){
		if ( $('.cosmos-header').length ) {
			var list_ele = $('.commont-menu a.menu__link');
			list_ele.click(function(e){
				if ( $(this).closest('.menu-mb li').children(".parent-sub-menu").length != true ) {
					var target_ele = $(this).attr('data-hashtag');
					if(typeof target_ele !== 'underfined' && $('#'+target_ele).length ){
						e.stopPropagation();
						e.preventDefault();
						if ( $(window).width() <= 1325 ) {
							$('#nav-toggle').trigger('click');
						}
						cosmos_fn.scroll_menu_to_section('#'+target_ele);
					}
				}
			});
			var hashtag = location.hash;
			if ( typeof hashtag !== 'underfined' && $(hashtag).length ) {
				cosmos_fn.scroll_menu_to_section(hashtag);
			}
		}
	}

	cosmos_fn.scroll_menu_to_section = function(target_ele){
		if(typeof target_ele !== 'underfined' && $(target_ele).length ){
			var height_ele = $(target_ele).offset().top;
			var time_scroll = 0;
			if(height_ele - $(window).scrollTop() < 0){
				time_scroll = (height_ele - $(window).scrollTop()) * (-1);
			}else{
				time_scroll = height_ele - $(window).scrollTop();
			}
			var offset_section = $(target_ele).offset().top;
			var height_adminbar = 0;
			if ( $('#wpadminbar').length ) {
				height_adminbar = $('#wpadminbar').height();
				offset_section = offset_section + height_adminbar;
			}
			$('html, body').stop().animate({
				scrollTop: offset_section
			}, (height_ele <= 300) ? 900 : (time_scroll/500) * 250);
			return false;
		}
	}

	cosmos_fn.scroll_window_active_menu = function(){
		if ( $('.cosmos-header').length ) {
			var list_component = $('.js-dynamic-menu');
			var list_menu = $('.commont-menu .menu__item');
			var list_menu_remove_class = $(".commont-menu .menu-head-page > .menu-des > .menu__item,.commont-menu .menu-head-page > .menu-mb > .menu__item");
			
			var index_active = 'default';
			var time_run_active;
			$(window).on("load scroll",function(e){
				var pos_win = $(window).scrollTop();
				list_component.each(function(i,val){
					if(pos_win >= ($(this).offset().top - 30) && pos_win <= ($(this).height() + $(this).offset().top)){
						index_active = $(this).attr('id');
					}
				});
				if(index_active != 'default' && $(('.menu__link[data-hashtag='+index_active+']')).length ){
					list_menu_remove_class.removeClass("active");

					list_menu.children('.menu__link[data-hashtag='+index_active+']').closest('.menu__item').addClass('active');

					/*for menu type 2*/
					if($('.commont-menu').hasClass('navi-type-2')){
						list_menu_remove_class.removeClass('active').find('a').removeClass('effect-zoom');
						list_menu.children('.menu__link[data-hashtag='+index_active+']').closest('.menu__item').addClass('active').children('.menu__link').addClass('effect-zoom');
					}
					cosmos_fn.ActiveNavigation3();
					history.pushState(null, null, '#'+index_active);
				}
			});
		}
	}

	cosmos_fn.remove_active_window_load = function(){
		if ( $('.cosmos-header').length ) {
			var list_menu_des = $(".commont-menu .menu-head-page > .menu-des > .menu__item");
			list_menu_des.each(function(index, el) {
				if ( index != 0 ) {
					$(this).removeClass('active');
				}
			});
			
			var list_menu_mb = $(".commont-menu .menu-head-page > .menu-mb > .menu__item");
			list_menu_mb.each(function(index, el) {
				if ( index != 0 ) {
					$(this).removeClass('active');
				}
			});
		}
	}

	cosmos_fn.menu_style = function(){
		if ( $('.commont-menu').length ) {
			if ( $('.commont-menu').hasClass('navi-type-3') == true ) {
				$('.commont-menu.navi-type-3').find('.menu-des').append('<li class="dot_slide"><span></span><span></span><span></span></li>');
				setTimeout(function() {
					$('.commont-menu.navi-type-3 .menu-des > li.menu__item').hover(function(){
						cosmos_fn.ActiveNavigation3Hover($(this));
					}, function(){
						cosmos_fn.ActiveNavigation3();
					});

				}, 500);
			}
		}
	}
	cosmos_fn.ActiveNavigation3Hover = function(parathis){
		if ( $('.commont-menu').length ) {
			var ele_span = $('.navi-type-3 .menu-des > li.dot_slide span');
			var ele_hover = parathis;
			var pos_left = 0;
			var status = '';
			var curent = 0;
			// check elemet exist
			if ( $(ele_hover).length ) {
				pos_left = ele_hover.position().left + (ele_hover.width()/2) - 3;
			} 

			if(pos_left > curent){
				status = 'right';
				curent = pos_left;
			}else{
				status = 'left';
				curent = pos_left;
			}
			if(status == 'left'){
				ele_span.eq(0).stop().animate({
				'left': (pos_left - 10) + 'px'
				},700);
				ele_span.eq(1).stop().animate({
					'left': pos_left + 'px'
				},750);
				ele_span.eq(2).stop().animate({
					'left': (pos_left + 10) + 'px'
				},900);
			}else{
				ele_span.eq(0).stop().animate({
				'left': (pos_left - 10) + 'px'
				},900);
				ele_span.eq(1).stop().animate({
					'left': pos_left + 'px'
				},750);
				ele_span.eq(2).stop().animate({
					'left': (pos_left + 10) + 'px'
				},700);
			}
		}
	}
	cosmos_fn.ActiveNavigation3 = function(){
		if ( $('.commont-menu').length ) {
			var ele_span = $('.navi-type-3 .menu-des > li.dot_slide span');
			var ele_active = $('.menu-des > li.menu__item.active');
			var ele_li = $('.menu-des > li.menu__item:first-child');
			var pos_left = 0;
			var status = '';
			var curent = 0;
			// check elemet exist
			if ( $(ele_active).length ) {
				pos_left = ele_active.position().left + (ele_active.width()/2) - 3;
			} else if ( $(ele_li).length ) {
				pos_left = ele_li.position().left + (ele_li.width()/2) - 3;
			}

			if(pos_left > curent){
				status = 'right';
				curent = pos_left;
			}else{
				status = 'left';
				curent = pos_left;
			}
			if(status == 'left'){
				ele_span.eq(0).stop().animate({
				'left': (pos_left - 10) + 'px'
				},700);
				ele_span.eq(1).stop().animate({
					'left': pos_left + 'px'
				},750);
				ele_span.eq(2).stop().animate({
					'left': (pos_left + 10) + 'px'
				},900);
			}else{
				ele_span.eq(0).stop().animate({
				'left': (pos_left - 10) + 'px'
				},900);
				ele_span.eq(1).stop().animate({
					'left': pos_left + 'px'
				},750);
				ele_span.eq(2).stop().animate({
					'left': (pos_left + 10) + 'px'
				},700);
			}
		}
	}


	/*-----------Back to Top----------------*/
	/*Check to see if the window is top if not then display button*/
	cosmos_fn.scroll_to_top = function(){
		if($(window).scrollTop() > $(window).outerHeight()){
			$(".back-on-top").css("bottom","20px");
		}else{
			$(".back-on-top").css("bottom","-50px");
		}

		$(".back-on-top").on("click",function(){
			$("html, body").stop().animate({scrollTop:0}, '1000', 'swing', function() { });
		});
	};
	cosmos_fn.loading_page = function(){
		if($('.loading-wrap').length){
			$(".loading-wrap").remove();
		}
	};

	/* Related Post On Single */
	cosmos_fn.related_post_single = function(){
		cosmos_fn.mycarousel(".section_blog_detail",1,1,1,false,false,false,false);
	};

	cosmos_fn.mycarousel = function(id,itemdestop,itemtable,itemmobile,itemloop,dots,autoplay,itemmargin){
		try{
			$(id).find(".carousel").each(function(){
				if(itemdestop == 1 && itemtable == 1 && itemmobile == 1){
					var owl=$(this).find(".carousel-items").owlCarousel({
					 	singleItem:true,
						loop:itemloop,
						pagination:dots,
						autoPlay:autoplay,
						slideSpeed:1000,
						stopOnHover:true,
						autoPlayTimeOut:1000,
					});
					$(this).find(".carousel-prev").click(function(){
						 owl.trigger('owl.prev');
					});
					$(this).find(".carousel-next").click(function(){
						owl.trigger('owl.next');
					});
				}
				else{
					var owl=$(this).find(".carousel-items").owlCarousel({
						items:itemdestop,
						loop:itemloop,
						pagination:dots,
						autoPlay:autoplay,
						slideSpeed:1000,
						margin:itemmargin,
						stopOnHover:true,
						itemsDesktop :[1199,itemtable],
						itemsDesktopSmall:[991,itemtable],
						itemsTablet :[767,itemmobile],
					});
					$(this).find(".carousel-prev").click(function(){
						 owl.trigger('owl.prev');
					});
					$(this).find(".carousel-next").click(function(){
						owl.trigger('owl.next');
					});
				}
			});
		}
		catch(err){
			console.log(err);
		}
	}

	/* Tool Box*/
	cosmos_fn.tool_box = function(){
		if ( $('.theme-setting').length ) {
			if(cosmos_fn.getCookie("choose-theme")){
				$("#cosmos-skin-color-css").attr("href",cosmos_fn.getCookie("choose-theme"));
				$(".theme-skin-color-item").removeClass("active");
				$(".theme-skin-color-item[data-href='"+cosmos_fn.getCookie("choose-theme")+"']").addClass("active");
				$(".sc-block-title .template-header-logo img").attr("src",$(".theme-skin-color-item.active").attr("data-logo"));
			}
			$(".theme-skin-color-item").on("click",function(){
				$(".theme-skin-color-item").removeClass("active");
				$(this).addClass("active");
				var now = new Date(); 
				var n = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
				document.cookie = "choose-theme="+$(this).attr("data-href")+"; expires="+n.toUTCString()+"; path=/";

				$("#cosmos-skin-color-css").attr("href",cosmos_fn.getCookie("choose-theme"));
				$(".sc-block-title .template-header-logo img").attr("src",$(this).attr("data-logo"));
			});
			$(".button-theme-setting").on("click",function(){
				if($(this).parent().hasClass("active")){
					$(this).parent().removeClass("active");
				}
				else{
					$(this).parent().addClass("active");
				}
			});
		}
	}
	cosmos_fn.getCookie = function(cname) {
	    var name = cname + "=";
	    var decodedCookie = decodeURIComponent(document.cookie);
	    var ca = decodedCookie.split(';');
	    for(var i = 0; i <ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0) == ' ') {
	            c = c.substring(1);
	        }
	        if (c.indexOf(name) == 0) {
	            return c.substring(name.length, c.length);
	        }
	    }
	    return "";
	}

	/* Animate */
	var animateArr=[];
	cosmos_fn.AnimateInit = function (){
		if($(window).width()>1200){
			$(".animate-run").each(function(){
				var animate = $(this).attr('data-animate');
				if (typeof animate !== 'undefined') {
					animateArr.push($(this));
					if( animate.split("-").length > 1 ){
						$(this).children().css("opacity","0");
					}
					else{
						$(this).css("opacity","0");
					}
				}
			});
		}
	};

	cosmos_fn.AnimateScroll = function (){
		if($(window).width()>1200){
			var window_offset_top = $(window).scrollTop();
			var window_offset_bottom = $(window).scrollTop() + $(window).height();
			var elementRemoveArray=[];
			var timeRunAnimate=0;
			for(var i=0;i<animateArr.length;i++){
				var currentElement = animateArr[i];
				var animateCss = animateArr[i].attr("data-animate");
				var animateDelay = animateArr[i].attr("data-delay") || 0;
				if ( typeof animateCss !== 'undefined' ) {
					var split = animateCss.split("-");
					var element_offset_top = currentElement.offset().top;
					var element_offset_bottom= currentElement.offset().top + currentElement.height();
					if( element_offset_top <= ( window_offset_bottom ) ) {
						if(split.length>1){
							for(var j=0;j<currentElement.children().length ;j++){
								cosmos_fn.delayRunAnimateParent(currentElement.children().eq(j),split[0],timeRunAnimate,animateDelay);
								timeRunAnimate+=400;
								cosmos_fn.removeClassAnimate(currentElement.children(),split[0]);
							}
							elementRemoveArray.push(i);
						} else {
							cosmos_fn.delayRunAnimate(currentElement,animateDelay,animateCss);
							elementRemoveArray.push(i);
							cosmos_fn.removeClassAnimate(currentElement,animateCss);
						}
					}				
				}
			}
			for(var i=elementRemoveArray.length - 1;i >= 0;i--){
				animateArr.splice(elementRemoveArray[i], 1);
			}
		}
	};
	cosmos_fn.delayRunAnimate = function (currentElement,animateDelay,animateCss){
		setTimeout(function(){
			currentElement.removeAttr("style").addClass('animated '+animateCss);
		}, animateDelay);
	};

	cosmos_fn.delayRunAnimateParent = function (currentElement,animateCss,timeRunAnimate,animateDelay){
		setTimeout(function(){
			cosmos_fn.delayRunAnimate(currentElement,animateDelay,animateCss);
		},timeRunAnimate);
		
	};

	cosmos_fn.removeClassAnimate = function (id,animateCss){
		setTimeout(function(){
			id.removeClass("animated "+animateCss);
		}, 3000);
	};

	/*======================================
	=			INIT FUNCTIONS			=
	======================================*/

	$(document).ready(function() {
		cosmos_fn.hide_loading();
		cosmos_fn.init_header();
		cosmos_fn.menu_header();
		cosmos_fn.scroll_menu_click();
		cosmos_fn.scroll_window_active_menu();
		cosmos_fn.remove_active_window_load();
		cosmos_fn.related_post_single();
		cosmos_fn.menu_style();
		cosmos_fn.ActiveNavigation3();
		cosmos_fn.AnimateInit();
	});
	$( window ).resize( function() {
		cosmos_fn.init_header();
	});
	$(window).on("load", function() {
		cosmos_fn.scroll_to_top();
		cosmos_fn.loading_page();
		cosmos_fn.tool_box();
		cosmos_fn.AnimateScroll();
	});
	$(window).on("scroll", function() {
		cosmos_fn.scroll_to_top();
		cosmos_fn.init_header();
		cosmos_fn.AnimateScroll();
	});

	/*=====  End of INIT FUNCTIONS  ======*/
});