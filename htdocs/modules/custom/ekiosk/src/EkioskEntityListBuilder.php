<?php

namespace Drupal\ekiosk;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
// use Drupal\DateTime;

/**
 * Defines a class to build a listing of Ekiosk entity entities.
 *
 * @ingroup ekiosk
 */
class EkioskEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Ekiosk entity ID');
    $header['name'] = $this->t('Name');
    $header['type'] = $this->t('Type');
    $header['date'] = $this->t('Date');  // CUSTOM 1 line
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\ekiosk\Entity\EkioskEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.ekiosk_entity.edit_form',
      ['ekiosk_entity' => $entity->id()]
    );
    $row['type'] = $entity->bundle(); // CUSTOM 3 lines
    $row['date'] = $entity->getDate();

    return $row + parent::buildRow($entity);
  }
}
