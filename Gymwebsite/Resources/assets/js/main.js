;(function () {
	
	'use strict';



	// iPad and iPod detection	
	var isiPad = function(){
		return (navigator.platform.indexOf("iPad") != -1);
	};

	var isiPhone = function(){
	    return (
			(navigator.platform.indexOf("iPhone") != -1) || 
			(navigator.platform.indexOf("iPod") != -1)
	    );
	};

	// Main Menu Superfish
	var mainMenu = function() {

		$('#fh5co-primary-menu').superfish({
			delay: 0,
			animation: {
				opacity: 'show'
			},
			speed: 'fast',
			cssArrows: true,
			disableHI: true
		});

	};

	// Parallax
	var parallax = function() {
		$(window).stellar();
	};


	// Offcanvas and cloning of the main menu
	var offcanvas = function() {

		var $clone = $('#fh5co-menu-wrap').clone();
		$clone.attr({
			'id' : 'offcanvas-menu'
		});
		$clone.find('> ul').attr({
			'class' : '',
			'id' : ''
		});

		$('#fh5co-page').prepend($clone);

		// click the burger
		$('.js-fh5co-nav-toggle').on('click', function(){

			if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
			} else {
				$('body').addClass('fh5co-offcanvas');
			}
			// $('body').toggleClass('fh5co-offcanvas');

		});

		$('#offcanvas-menu').css('height', $(window).height());

		$(window).resize(function(){
			var w = $(window);


			$('#offcanvas-menu').css('height', w.height());

			if ( w.width() > 769 ) {
				if ( $('body').hasClass('fh5co-offcanvas') ) {
					$('body').removeClass('fh5co-offcanvas');
				}
			}

		});	

	}

	

	// Click outside of the Mobile Menu
	var mobileMenuOutsideClick = function() {
		$(document).click(function (e) {
	    var container = $("#offcanvas-menu, .js-fh5co-nav-toggle");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {
	      if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
			}
	    }
		});
	};


	// Animations

	var contentWayPoint = function() {
		var i = 0;
		$('.animate-box').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .animate-box.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							el.addClass('fadeInUp animated');
							el.removeClass('item-animate');
						},  k * 200, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '85%' } );
	};
	

	var scheduleTab = function() {
		$('.schedule-container').css('height', $('.schedule-content.active').outerHeight());

		$(window).resize(function(){
			$('.schedule-container').css('height', $('.schedule-content.active').outerHeight());
		});

		$('.schedule a').on('click', function(event) {
			
			event.preventDefault();

			var $this = $(this),
				sched = $this.data('sched');

			$('.schedule a').removeClass('active');
			$this.addClass('active');
			$('.schedule-content').removeClass('active');

			$('.schedule-content[data-day="'+sched+'"]').addClass('active');

		});
	};

	// Document on load.
	$(function(){
		mainMenu();
		parallax();
		offcanvas();
		mobileMenuOutsideClick();
		contentWayPoint();
		scheduleTab();
	});

	$('#joinsendmessage',).on('click', function(){
		var email 		= $('#joinemail').val();
		var mobile 		= $('#joinmobile').val();
		var message 	= $('#joinmessage').val();
		var program_title 	= $('#joinnowmodal .modal-title').html();

		  $.ajax({
		    type: 'POST',
		    url:  global_data.ajax_url,
		    data:{
		      _token: global_data.token,
		      action: 'send_join_request',
		      email: email,
		      mobile: mobile,
		      message: message,
		      program_title: program_title
		    },
			success: function(data) {				
				data = JSON.parse(data);
                if($.isEmptyObject(data.error)){
                	$(".print-error-msg").find("ul").html('');
                	$(".print-error-msg").css('display','block');
                	$(".print-error-msg").find("ul").append('<li class="alert alert-success">'+data.success+'</li>');
           			
					$('#joinemail').val('');
					$('#joinmobile').val('');
					$('#joinmessage').val('');     
					setTimeout(function(){
						$('#joinnowmodal').modal('hide');
					}, 2500);
                }else{
                	printErrorMsg(data.error);
                }
            }

		  });
	});


$('#joinnowmodal').on('hidden.bs.modal', function (e) {
	$(".print-error-msg").find("ul").html('');
	$(".print-error-msg").css('display','none');
})



}());

var commentformhtml 	= $('#comment_form_html').html();

function printErrorMsg (msg) {
	$(".print-error-msg").find("ul").html('');
	$(".print-error-msg").css('display','block');
	$.each( msg, function( key, value ) {
		$(".print-error-msg").find("ul").append('<li class="alert alert-danger">'+value+'</li>');
	});
}


function openJoinNowModal(th){
	var thisval = $(th);
	$('#joinnowmodal .modal-title').html(thisval.attr('post-title'))
	$('#joinnowmodal').modal();
}
