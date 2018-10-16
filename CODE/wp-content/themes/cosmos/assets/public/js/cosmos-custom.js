// JavaScript Document
(function($) {
	"use strict";
	var cosmos_datepicker = function() {
		$('.datetimepicker12').each(function (){
			$(this).datetimepicker({
				inline: true
			});
		var dayOfWeek, dayOfMonth, jsDate;
		var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
		$(this).on("dp.change", function(e) {
			jsDate = dataFromTimestamp(e.date);
			dayOfWeek = days[jsDate.dayInTheWeek];
			dayOfMonth = jsDate.dayInMonth + getOrdinal(jsDate.dayInMonth);
			$(this).find('.date-label').text('');
			$(this).find('.picker-switch').append('<span class="date-label">'+ dayOfWeek + ' ' + dayOfMonth +'</span>');
		});
		$(this).on("dp.update", function(e) {
			var str = $('.date-label').text();
			$(this).find('.date-label').text('');
			$(this).find('.picker-switch').append('<span class="date-label">'+ str +'</span>');
		});

		getDateLabel($('.day.active').attr('data-day'));
		function dataFromTimestamp(timestamp){
			var d = new Date(timestamp);

			// Time
			var h = addZero(d.getHours());              //hours
			var m = addZero(d.getMinutes());            //minutes
			var s = addZero(d.getSeconds());            //seconds

			// Date
			var da = d.getDate();                       //day
			var mon = d.getMonth() + 1;                 //month
			var yr = d.getFullYear();                   //year
			var dw = d.getDay();                        //day in week

			// Readable feilds
			var months = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
			var monName = months[d.getMonth()];         //month Name
			var time = h + ":" + m + ":" + s;           //full time show
			var thisDay = da + "/" + mon + "/" + yr;    //full date show

			var dateTime = {
				seconds : s,
				minutes : m,
				hours : h,
				dayInMonth : da,
				month : mon,
				year : yr,
				dayInTheWeek : dw,
				monthName : monName,
				fullTime : time,
				fullDate : thisDay
			};
			return dateTime;

			function addZero(i) {
				if (i < 10) {
					i = "0" + i;
				}
				return i;
			}
		}
		function getOrdinal(val){

			var mod = val % 10;
			if (mod === 1 && val !== 11) {
				return 'st';
			} else if (mod === 2 && val !== 12) {
				return 'nd';
			} else if (mod === 3 && val !== 13) {
				return 'rd';
			} else {
				return 'th';
			}
		}
		function getDateLabel(val){
			jsDate = new Date(val);
			dayOfWeek = days[jsDate.getDay()];
			dayOfMonth = jsDate.getDate() + getOrdinal(jsDate.getDate());
			 $(this).find('.picker-switch').append('<span class="date-label">'+ dayOfWeek + ' ' + dayOfMonth +'</span>');
		}
		})
		
	};
	var cosmos_calendar = function(){
		$('.widget_calendar').each(function() {
			$(this).find('.calendar_wrap').remove();
			$(this).find('#calendar_wrap').remove();
			$(this).addClass('archives-widget');
			$(this).append('<div class="content-widget"><div class="archive-datepicker"></div></div>')
		});
		$('.input-daterange, .archive-datepicker').datepicker({
			format: 'mm/dd/yy',
			maxViewMode: 0
		});
	}

	//css for widget default
	var cosmos_custom_widget_default = function() {
		$('.pix-widget').find('ul').addClass('list-unstyled');
	};

	/**
	 * Comment
	 */
	var cosmos_comment = function() {
		$('.comment-form').find('.comment-col1').wrap( "<div class='col-50' />");
		$("#submit",$("#commentform")).click(function () {
			var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
			var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
			var isError	= false;
			var focusEle   = null; 
			$("#commentform .input-error-msg").addClass('hide');
			$("#commentform input, #commentform textarea").removeClass('input-error');
			if ( $("#author").length ){
				if($("#comment").val().trim() == '' ){
					$('#comment-err-required').removeClass('hide');
					$("#comment").addClass('input-error');
					isError  = true;
					focusEle = "#comment";
				}
				else if($("#author").val().trim() == '' ) {
						$('#author-err-required').removeClass('hide');
						$("#author").addClass('input-error');
						isError  = true;
						focusEle = "#author";
					}
				else if($("#email").val().trim() == '' ){
					$('#email-err-required').removeClass('hide');
					$("#email").addClass('input-error');
					isError  = true;
					focusEle = "#email";
				}
				else if(!$("#email").val().match(emailRegex)){
					$('#email-err-valid').removeClass('hide');
					$("#email").addClass('input-error');
					isError  = true;
					focusEle = "#email";
				}
			}else{
				if($("#comment").val().trim() == '' ){
					$('#comment-err-required').removeClass('hide');
					$("#comment").addClass('input-error');
					isError  = true;
					focusEle = "#comment";
				}
			}
			if(isError){
				$(focusEle).focus();
				return false;
			}
			return true;
		});
		$('.entry-comment .comment-field').each(function(){
			if ($(this).val()){
				$(this).addClass('edited');
			}
		})
	}; // end comment func
	
	/**
	 * Initial Script
	 */
	$(document).ready(function() {
		cosmos_custom_widget_default();
		cosmos_calendar();
		cosmos_comment();
	});
})(jQuery);