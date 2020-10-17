/**
 * File to handle fixed top menubar
 */
 document.addEventListener( "DOMContentLoaded", function() {
	 var adminBar = document.getElementById( 'wpadminbar' );
	 var topMenu = document.getElementById( 'site-header' );
	 
// Offset the page (body) by the height of the topMenu
 if( adminBar ) {
	 document.body.style.marginTop = ( topMenu.offsetHeight + 32 ) + "px";
	 topMenu.style.top = '32px';
 } else {
	 document.body.style.marginTop = topMenu.offsetHeight + "px";
 }
 
 // As we scroll down, hide the top menubar
 var lastScrollPosition = 0;
 
 window.onscroll = function() {
	 var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	 
	 if( scrollTop > lastScrollPosition && scrollTop > topMenu.offsetHeight ) {
		 topMenu.style.top = '-200px';
	 } else {
		 if( ! adminBar ) {
			 topMenu.style.top = '0';
		 } else {
			 topMenu.style.top = '32px';
		 }
	 }
	 
	 lastScrollPosition = scrollTop <= 0 ? 0 : scrollTop;
 }

 }, false );
 
 