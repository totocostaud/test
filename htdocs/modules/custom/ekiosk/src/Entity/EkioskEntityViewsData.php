<?php

namespace Drupal\ekiosk\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Ekiosk entity entities.
 */
class EkioskEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    /*$data['ekiosk']['table']['base'] = array(
        'type' => 'type',
        'title' => t('Ekiosk'),
        'help' => t('The ekiosk entity ID.'),
    );*/

    return $data;
  }

}
