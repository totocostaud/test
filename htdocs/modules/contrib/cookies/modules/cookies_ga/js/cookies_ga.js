/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */;

(function (Drupal) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookies_ga = {

    activate: function () {
      var scriptIds = [
        'cookies_google_analytics_tracking_script',
        'cookies_google_analytics_tracking_file'
      ];
      for (var i in scriptIds) {
        var script = document.getElementById(scriptIds[i]);
        if (script) {
          var content = script.innerHTML;
          var newScript = document.createElement('script');
          var attributes = Array.from(script.attributes);
          for (var attr in attributes) {
            var name = attributes[attr].nodeName;
            if (name !== 'type') {
              newScript.setAttribute(name, attributes[attr].nodeValue);
            }
          }
          newScript.innerHTML = content;
          script.parentNode.replaceChild(newScript, script);
        }
      }
    },

    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service['analytics'] !== 'undefined' && service['analytics']) {
          self.activate(context);
        }
      });
    }
  }
})(Drupal);
