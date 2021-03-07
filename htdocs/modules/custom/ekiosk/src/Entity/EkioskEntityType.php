<?php

namespace Drupal\ekiosk\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Ekiosk entity type entity.
 *
 * @ConfigEntityType(
 *   id = "ekiosk_entity_type",
 *   label = @Translation("Ekiosk entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EkioskViewBuilder",
 *     "list_builder" = "Drupal\ekiosk\EkioskEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ekiosk\Form\EkioskEntityTypeForm",
 *       "edit" = "Drupal\ekiosk\Form\EkioskEntityTypeForm",
 *       "delete" = "Drupal\ekiosk\Form\EkioskEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ekiosk\EkioskEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ekiosk_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "ekiosk_entity",
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
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/ekiosk/ekiosk_entity_type/{ekiosk_entity_type}",
 *     "add-form" = "/admin/structure/ekiosk/ekiosk_entity_type/add",
 *     "edit-form" = "/admin/structure/ekiosk/ekiosk_entity_type/{ekiosk_entity_type}/edit",
 *     "delete-form" = "/admin/structure/ekiosk/ekiosk_entity_type/{ekiosk_entity_type}/delete",
 *     "collection" = "/admin/structure/ekiosk/ekiosk_entity_type"
 *   }
 * )
 */
class EkioskEntityType extends ConfigEntityBundleBase implements EkioskEntityTypeInterface {

  /**
   * The Ekiosk entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Ekiosk entity type label.
   *
   * @var string
   */
  protected $label;

}
