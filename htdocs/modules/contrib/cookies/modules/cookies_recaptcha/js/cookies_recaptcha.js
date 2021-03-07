/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */

(function (Drupal, $) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookies_recaptcha = {
    // id corresponding to the cookies_service.schema->id.
    id: 'recaptcha',

    activate: function () {
      var script = document.getElementById('cookies_recaptcha');
      if (script) {
        var newScript = document.createElement('script');
        var attributes = Array.from(script.attributes);
        for (var attr in attributes) {
          var name = attributes[attr].nodeName;
          if (name !== 'type') {
            newScript.setAttribute(name, attributes[attr].nodeValue);
          }
        }
        newScript.innerHTML = script.innerHTML;
        script.parentNode.replaceChild(newScript, script);
      }
    },

    fallback: function (context) {
      $('.g-recaptcha', context).cookiesOverlay('recaptcha');
    },


    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service[self.id] !== 'undefined' && service[self.id]) {
          self.activate(context);
        } else {
          self.fallback(context);
        }
      });
    }
  }
})(Drupal, jQuery);
