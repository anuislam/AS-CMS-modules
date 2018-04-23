window.onload = function() {
    jQuery('div.workdiary_preloader').fadeOut(500);
    
};


jQuery(document).ready(function($){

  hljs.initHighlightingOnLoad();
 $("div.post_social_share").jsSocials({
    url: share_url,
    text: share_text,
    shareIn: 'popup',
    showLabel: false,
    showCount: false,
    shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "email"]
});
    
$(function(){
    $('#mobile_menu').slicknav();
});

$('#slider_one').owlCarousel({
    loop:false,
    margin:30,
    nav:true,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    },
    navText: ['<i class="glyphicon glyphicon-chevron-left"></i>','<i class="glyphicon glyphicon-chevron-right"></i>']
});


$('#slider_two').owlCarousel({
    loop:false,
    margin:15,
    nav:true,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    },
    navText: ['<i class="glyphicon glyphicon-chevron-left"></i>','<i class="glyphicon glyphicon-chevron-right"></i>']
});





});



