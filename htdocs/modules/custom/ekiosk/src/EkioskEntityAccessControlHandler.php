<?php

namespace Drupal\ekiosk;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Entity\Access\EntityViewDisplayAccessControlHandler;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the ekiosk entity entity.
 *
 * @see \Drupal\Ekiosk\Entity\ekioskEntity.
 */
class EkioskEntityAccessControlHandler extends EntityViewDisplayAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ekiosk\Entity\EkioskEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished ekiosk entity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published ekiosk entity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit ekiosk entity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete ekiosk entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add ekiosk entity entities');
  }


}
