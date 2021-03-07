<?php

namespace Drupal\advertisement\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Advertisement entity type entity.
 *
 * @ConfigEntityType(
 *   id = "advertisement_entity_type",
 *   label = @Translation("Advertisement entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\advertisement\AdvertisementEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\advertisement\Form\AdvertisementEntityTypeForm",
 *       "edit" = "Drupal\advertisement\Form\AdvertisementEntityTypeForm",
 *       "delete" = "Drupal\advertisement\Form\AdvertisementEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\advertisement\AdvertisementEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "advertisement_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "advertisement_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
*     "id",
*     "label",
*     "description",
*     "weight"
*    },
 *   links = {
 *     "canonical" = "/admin/structure/advertisement/advertisement_entity_type/{advertisement_entity_type}",
 *     "add-form" = "/admin/structure/advertisement/advertisement_entity_type/add",
 *     "edit-form" = "/admin/structure/adverisement/advertisement_entity_type/{advertisement_entity_type}/edit",
 *     "delete-form" = "/admin/structure/advertisement/advertisement_entity_type/{advertisement_entity_type}/delete",
 *     "collection" = "/admin/structure/advertisement/advertisement_entity_type"
 *   }
 * )
 */
class AdvertisementEntityType extends ConfigEntityBundleBase implements AdvertisementEntityTypeInterface {

  /**
   * The Advertisement entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Advertisement entity type label.
   *
   * @var string
   */
  protected $label;

}
