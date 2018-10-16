jQuery(document).ready(function($) {
	"use strict";
	var Megamenu_Activator = '.menu-item-pix-show-megamenu';
	var Widget_Activator = '.menu-item-pix-show-widget';
	//click - Main Menu
	$(document).on('click', Megamenu_Activator, function() {
		var checkbox = $(this);
		if(checkbox.is(':checked')) {
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.menu-item-pix-show-megamenu').attr( 'checked', true );
			$(this).parents('.menu-item:eq(0)').find('.show-widget').addClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.megamenu-column').addClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.megamenu-style').addClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.tab-title').addClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').addClass('open');
			
		} else {
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.menu-item-pix-show-megamenu').attr( 'checked', false );
			$(this).parents('.menu-item:eq(0)').find('.show-widget').removeClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.tab-title').removeClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').removeClass('open');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.widget-column').removeClass('open');
			$(this).parents('.menu-item:eq(0)').find('.megamenu-column').removeClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.megamenu-style').removeClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').find('.tab-title').removeClass('pix-mega-menu-d0');
			$(this).parents('.menu-item:eq(0)').nextUntil('.menu-item-depth-0').find('.choose-widgetarea').removeClass('open');
		}
	});
	
});