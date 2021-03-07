<?php

namespace Drupal\advertisement;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
// use Drupal\DateTime;

/**
 * Defines a class to build a listing of Advertisement entity entities.
 *
 * @ingroup advertisement
 */
class AdvertisementEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Advertisement entity ID');
    $header['name'] = $this->t('Name');
    $header['type'] = $this->t('Type');  // CUSTOM 3 lines
    $header['start'] = $this->t('Start');
    $header['end'] = $this->t('End');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\advertisement\Entity\AdvertisementEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.advertisement_entity.edit_form',
      ['advertisement_entity' => $entity->id()]
    );
    $row['type'] = $entity->bundle(); // CUSTOM 3 lines
    $row['start'] = $entity->getAdv_start();
    $row['end'] = $entity->getAdv_end();

    return $row + parent::buildRow($entity);
  }
}
