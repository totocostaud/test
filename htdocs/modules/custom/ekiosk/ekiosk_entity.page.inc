<?php

/**
 * @file
 * Contains ekiosk_entity.page.inc.
 *
 * Page callback for Ekiosk entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Ekiosk entity templates.
 *
 * Default template: ekiosk_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_ekiosk_entity(array &$variables) {

  // Fetch EkioskEntity Entity Object.
  $ekiosk_entity = $variables['elements']['#ekioskentity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}


