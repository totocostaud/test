<?php

namespace Drupal\advertisement\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Advertisement entity entities.
 */
class AdvertisementEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
