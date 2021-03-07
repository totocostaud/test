/**
 * @file
 * interstitial.js
 * 
 * Closing the colorbox used by splashify module after a certain time
 * and css correction to get less opacity on the overlay
 *  
 * @param $
 * @param Drupal
 * @param drupalSettings
 * @returns
 * 
 * Doc : https://browse-tutorials.com/snippet/use-colorbox-programmatically-drupal
 */

(function ($, Drupal, drupalSettings) {
  /**
   * @namespace interstitial
   */
Drupal.behaviors.advertisementInterstitial = {
  attach: function (context, settings) {
	
    // Check if there's an interstitial 
	if ($('#interstitial-link').length) {
		
		// get the base url to implemente in the link to come
		var base_url = location.protocol + "//" + location.host; 
		
		// cookie management
		if (document.cookie.indexOf('visited=true') == -1) {
	        var twelveHours = 1000*60*60*12;
	        var expires = new Date((new Date()).valueOf() + twelveHours);
	        document.cookie = "visited=true;expires=" + expires.toUTCString();
		$.colorbox({href: base_url+ "/sites/default/files/images/advertisement/interstitial_pages/interstitial.html"});
		}
	}	

	if ($('#cboxOverlay').length) {
        	$('#cboxOverlay').css('opacity', '0.70' );
  	    setTimeout(
  	      function() {
             	$.colorbox.close();
            }, 8000 
        );
     }
  }
};
})(jQuery, Drupal, drupalSettings);

