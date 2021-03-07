<?php

namespace Drupal\advertisement\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Advertisement entity entity.
 *
 * @ingroup advertisement
 *
 * @ContentEntityType(
 *   id = "advertisement_entity",
 *   label = @Translation("Advertisement entity"),
 *   bundle_label = @Translation("Advertisement entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\advertisement\AdvertisementEntityListBuilder",
 *     "views_data" = "Drupal\advertisement\Entity\AdvertisementEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\advertisement\Form\AdvertisementEntityForm",
 *       "add" = "Drupal\advertisement\Form\AdvertisementEntityForm",
 *       "edit" = "Drupal\advertisement\Form\AdvertisementEntityForm",
 *       "delete" = "Drupal\advertisement\Form\AdvertisementEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\advertisement\AdvertisementEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\advertisement\AdvertisementEntityAccessControlHandler",
 *   },
 *   base_table = "advertisement_entity",
 *   translatable = FALSE,
 *   admin_permission = "administer advertisement entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/advertisement_entity/{advertisement_entity}",
 *     "add-page" = "/admin/structure/advertisement_entity/add",
 *     "add-form" = "/admin/structure/advertisement_entity/add/{advertisement_entity_type}",
 *     "edit-form" = "/admin/structure/advertisement_entity/{advertisement_entity}/edit",
 *     "delete-form" = "/admin/structure/advertisement_entity/{advertisement_entity}/delete",
 *     "collection" = "/admin/structure/advertisement_entity",
 *   },
 *   bundle_entity_type = "advertisement_entity_type",
 *   field_ui_base_route = "entity.advertisement_entity_type.edit_form"
 * )
 */
class AdvertisementEntity extends ContentEntityBase implements AdvertisementEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getAdv_start() {
    return $this->get('adv_start')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setAdv_start($adv_start) {
    $this->set('adv_start', $adv_start);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getAdv_end() {
    return $this->get('adv_end')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setAdv_end($adv_end) {
    $this->set('adv_end', $adv_end);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getAdv_link() {
    return $this->get('adv_link')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setAdv_link($adv_link) {
    $this->set('adv_link', $adv_link);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getAdv_file() {
    return $this->get('adv_file')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setAdv_file($adv_file) {
    $this->set('adv_file', $adv_file);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Advertisement entity entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    // Start field for the advertisement.
    $fields['adv_start'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start'))
      ->setDescription(t('Start date for the display.'))
      ->setSettings(array(
        'datetime_type' => 'date',
      ))
      ->setDefaultValue(array(0 => array(
        'default_date_type' => 'now',
        'default_date' => 'now',
      )))
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'datetime_default',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'datetime_default',
        'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    // End field for the advertisement.
    $fields['adv_end'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End'))
      ->setDescription(t('End date (included day) for the display.'))
      ->setSettings(array(
        'datetime_type' => 'date',
      ))
      ->setDefaultValue(array(0 => array(
        'default_date_type' => 'now',
        'default_date' => 'now',
      )))
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'datetime_default',
        'weight' => -2,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'datetime_default',
        'weight' => -2,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    // Link field for the advertisement.
    $fields['adv_link'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Link'))
      ->setDescription(t('Link for this advertisement.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    // File upload field for the advertisement.
    $fields['adv_file'] = BaseFieldDefinition::create('file')
      ->setLabel(t('Upload file'))
      ->setSetting('file_directory', 'images/advertisement')
      ->setSetting('max_filesize', '10MB')
      ->setSetting('file_extensions', 'jpg jpeg gif png') // extensions separated with a space
      ->setSetting('description_field', FALSE)
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'file_generic',
        'weight' => 4,
        ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Advertisement entity is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}
