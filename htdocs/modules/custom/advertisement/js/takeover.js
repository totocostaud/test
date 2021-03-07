/**
 * @file
 * themes/culturepresse/takever.js
 * 
 * The takeover variables are passed from the module file to the template page.html.twig
 * If there's a takeover, the div '#use-this-background-image' is valid
 * We just have to grab the text which is in the div '#use-this-background-image' (variable
 * containing the source of the image file) and the div '#use-this-top-margin' (variable 
 * containing the top margin). The link, which doesn't need to be altered in css,  is also 
 * directly passed though a variable. 
 * 
 * @param $
 * @param Drupal
 * @param drupalSettings
 * @returns
 */

(function ($, Drupal, drupalSettings) {
  /**
   * @namespace takeover
   */
Drupal.behaviors.advertisementAccessData = {
  attach: function (context, settings) {

    // var data = drupalSettings.advertisementTakeover;
    // alert( data['source'] );
	// var takeover = data['takeover'];
    // var source = data['source'];
    // var top_margin = data['top_margin'];
    
	// Testing if there's a div with this ID in the page template
	if ($('#takeover-background-image').length) {
      
      $('body').css('width','100%');
	  $('body').css('height','100%');
	  $('body').css('background-color','transparent'); /* no color to be able to see the backgound image */
      
	  /* 2 lines to be able to attach a link to the background image */
	  $('body').css('display', 'block');
	  $('body').css('position', 'absolute');
	  
	  // Getting the text in the div (twig variable) = source of the image. And positioning the background
	  $('body').css('background-image','url("' + $('#takeover-background-image').text() + '")');
	  $('body').css('background-repeat', 'no-repeat');
	  $('body').css('background-position', 'center top');
	  $('#takeover-background-image').css('width', '1600px');
	  
	  // Getting the text in the div (twig variable)
	  $('#header').css('margin-top', $('#takeover-top-margin').text() + 'px');
		
	  // Positioning the link to force it to cover the background image
	  $('.takeover-link').css('position','absolute');
	  $('.takeover-link').css('top', 0);
	  $('.takeover-link').css('left', '50%');
	  $('.takeover-link').css('margin-left', '-800px');
		
      $('#page').css('z-index', '100');
      $('#page-wrapper').css('z-index', '1000');
      $('.highlighted').css('z-index', '1000');
    }
  }
};
})(jQuery, Drupal, drupalSettings);