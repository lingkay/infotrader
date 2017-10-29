$(document).ready(function(){

// -------------- Main Menu Jquery

// $(".navbar-nav li").each( function() {

//   $(this).has("ul").append("<i class='fa fa-caret-down toggle-sub visible-sm visible-xs menu-caret'></i>").addClass("has-sub");

//   $(this).has("ul").find(">a").append(" <i class='fa fa-angle-down hidden-sm hidden-xs menu-caret'></i>");

// });
//
// $(window).on("resize", function () {
//
//   if ( $(window).width() >= 768 ){
//
//     $(".navbar-nav li:has(ul) .dropdown-menu").each( function() {
//
//         var subWidth = $(this).outerWidth();
//
//         $(this).css({ "margin-left" : - subWidth / 2 + "px", "left" : "50%", "display" : "none", "width" : subWidth });
//
//     });
//
//     $(".navbar-nav li:has(ul)").removeClass("open collapsible");
//
//   }
//
//   else {
//
//     $(".dropdown-menu").removeAttr( 'style' );
//
//   }
//
// }).resize();

$( ".navbar-nav .fa-caret-down" ).on( "click", function() {

  $(this).parent().find(".dropdown-menu").stop().slideToggle( "fast", function() {

    $(this).parent().toggleClass("open collapsible");

  });

});

// -------------- Placeholder Jquery

$('input, textarea').placeholder();

// -------------- Reject IE Jquery

$.reject({

  reject : {
      all: false,
      msie: 8
  },
  display: ['firefox','chrome','safari'],
  imagePath: 'assets/images/'

});

// -------------- New Jquery

if ( jQuery('[type="date"]').prop('type') != 'date' ) {
    jQuery('[type="date"]').datepicker();
}

jQuery(window).scroll(function () {
    jQuery(".parallax").css("background-position","50% " + (jQuery(this).scrollTop() / 6) + "px");
});

});
