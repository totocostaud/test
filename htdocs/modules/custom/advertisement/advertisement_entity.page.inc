<?php

/**
 * @file
 * Contains advertisement_entity.page.inc.
 *
 * Page callback for Advertisement entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Advertisement entity templates.
 *
 * Default template: advertisement_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_advertisement_entity(array &$variables) {

  // Fetch AdvertisementEntity Entity Object.
  $advertisement_entity = $variables['elements']['#advertisement_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}


