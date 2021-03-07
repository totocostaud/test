<?php

namespace Drupal\advertisement;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Entity\Access\EntityViewDisplayAccessControlHandler;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Advertisement entity entity.
 *
 * @see \Drupal\advertisement\Entity\AdvertisementEntity.
 */
class AdvertisementEntityAccessControlHandler extends EntityViewDisplayAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\advertisement\Entity\AdvertisementEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished advertisement entity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published advertisement entity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit advertisement entity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete advertisement entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add advertisement entity entities');
  }


}
