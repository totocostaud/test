<?php

namespace Drupal\advertisement;

use Drupal\Core\Entity\EntityViewBuilder;
use Drupal\Core\Entity\Display\EntityDisplayInterface;

/**
 * Defines the view builder for my_entity_type entities.
 */
class AdvertisementViewBuilder extends EntityViewBuilder {

  public function view(EntityDisplayInterface $entity, $view_mode = 'full', $langcode = NULL) {

    kint($entity);
    $full_output = $view_builder->view($entity);
    print 'graou'; die();

    return $full_output;
  }
}






