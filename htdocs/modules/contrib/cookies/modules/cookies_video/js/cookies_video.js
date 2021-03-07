/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */;
(function (Drupal, $) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookies_video = {
    activate: function (context) {
      $('iframe.cookies-video', context).each(function (i,element) {
        $(element).attr('src', $(element).data('src'));
      });
    },

    fallback: function (context) {
      $('iframe.cookies-video', context).cookiesOverlay('video');
    },

    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function(event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service['video'] !== 'undefined' && service['video']) {
          self.activate(context);
        } else {
          self.fallback(context);
        }
      });
    }

  }

})(Drupal, jQuery);
