<?php
/**
 * Docs pour les settings des BaseFieldDefinitions :
 * https://kgaut.net/snippets/2018/drupal-8-entite-champ-de-base-nombre-decimal.html, etc
 *
 */
namespace Drupal\ekiosk\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Ekiosk entity entity.
 *
 * @ingroup ekiosk
 *
 * @ContentEntityType(
 *   id = "ekiosk_entity",
 *   label = @Translation("Ekiosk entity"),
 *   bundle_label = @Translation("Ekiosk entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ekiosk\EkioskEntityListBuilder",
 *     "views_data" = "Drupal\ekiosk\Entity\EkioskEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\ekiosk\Form\EkioskEntityForm",
 *       "add" = "Drupal\ekiosk\Form\EkioskEntityForm",
 *       "edit" = "Drupal\ekiosk\Form\EkioskEntityForm",
 *       "delete" = "Drupal\ekiosk\Form\EkioskEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ekiosk\EkioskEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\ekiosk\EkioskEntityAccessControlHandler",
 *   },
 *   base_table = "ekiosk_entity",
 *   translatable = FALSE,
 *   admin_permission = "administer ekiosk entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/ekiosk_entity/{ekiosk_entity}",
 *     "add-page" = "/admin/structure/ekiosk_entity/add",
 *     "add-form" = "/admin/structure/ekiosk_entity/add/{ekiosk_entity_type}",
 *     "edit-form" = "/admin/structure/ekiosk_entity/{ekiosk_entity}/edit",
 *     "delete-form" = "/admin/structure/ekiosk_entity/{ekiosk_entity}/delete",
 *     "collection" = "/admin/structure/ekiosk_entity",
 *   },
 *   bundle_entity_type = "ekiosk_entity_type",
 *   field_ui_base_route = "entity.ekiosk_entity_type.edit_form"
 * )
 */
class EkioskEntity extends ContentEntityBase implements EkioskEntityInterface {

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
  public function setName($name) { //name = isuue number
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getCover_image() {
    return $this->get('cover_image')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setCover_image($cover_image) {
    $this->set('cover_image', $cover_image);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getFlipbook_link() {
    return $this->get('flipbook_link')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setFlipbook_link($flipbook_link) {
    $this->set('flipbook_link', $flipbook_link);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getDate() {
    return $this->get('date')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setDate($date) {
    $this->set('date', $date);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getMonth() {
    return $this->get('month')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setMonth($month) {
    $this->set('month', $month);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getYear() {
    return $this->get('year')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setYear($year) {
    $this->set('year', $year);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getPrice_ht() {
    return $this->get('price_ht')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setPrice_ht($price_ht) {
    $this->set('price_ht', $price_ht);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getTax() {
    return $this->get('tax')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setTax($tax) {
    $this->set('tax', $tax);
    return $this;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function getTotal_price() {
    return $this->get('total_price')->value;
  }

  /**
   * {@inheritdoc} CUSTOM
   */
  public function setTotal_price($total_price) {
    $this->set('total_price', $total_price);
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

    $fields['name'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Name'))
      ->setDescription(t('The number of the Ekiosk entity entity.'))
      ->setSettings([
        'max_length' => 4,
         'unsigned', TRUE,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    // Image upload field for the ekiosk.
      $fields['cover_image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Couv Image'))
      ->setSettings([
          'file_directory' => 'images/ekiosk',
          'alt_field_required' => FALSE,
          'file_extensions' => 'png jpg jpeg',
      ])
      ->setDisplayOptions('view', array(
          'label' => 'hidden',
          'type' => 'default',
          'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
          'label' => 'hidden',
          'type' => 'image_image',
          'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Date of issue.
    $fields['date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Date de parution'))
      ->setDescription(t('Date of issue.'))
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

    // Flipbook Link field for the ekiosk issue.
    $fields['flipbook_link'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Flipbook Link'))
      ->setDescription(t('Flipbook Link for this ekiosk issue.'))
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

      // Month of the ekiosk issue.
      $fields['month'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Month'))
      ->setDescription(t('Month of this ekiosk issue.'))
      ->setSettings([
          'allowed_values' => [
              'janvier' => 'janvier',
              'février' => 'février',
              'mars' => 'mars',
              'avril' => 'avril',
              'mai' => 'mai',
              'juin' => 'juin',
              'juillet' => 'juillet',
              'août' => 'août',
              'septembre' => 'septembre',
              'octobre' => 'octobre',
              'novembre' => 'novembre',
              'décembre' => 'décembre',
          ],
      ])
      ->setDisplayOptions('view', [
          'label' => 'visible',
          'type' => 'list_default',
          'weight' => 0,
      ])
      ->setDisplayOptions('form', [
          'type' => 'options_select',
          'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setRequired(TRUE);

      // Year of the ekiosk issue.
      $fields['year'] = BaseFieldDefinition::create('list_integer')
      ->setLabel(t('Year'))
      ->setDescription(t('Year of this ekiosk issue.'))
      ->setSettings([
          'allowed_values' => [
              2020 => 2020,
              2021 => 2021,
              2022 => 2022,
              2023 => 2023,
              2024 => 2024,
              2025 => 2025,
              2026 => 2026,
              2027 => 2027,
              2028 => 2028,
              2029 => 2029,
              2030 => 2030,
          ],
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
          'label' => 'visible',
          'type' => 'list_default',
          'weight' => 1,
      ])
      ->setDisplayOptions('form', [
          'type' => 'options_select',
          'weight' => 1,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

      // the price HT
      $fields['price_ht'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Prix HT'))
      ->setDescription(t('The price HT of the Ekiosk entity entity.'))
      ->setSetting('unsigned', TRUE)
      ->setSetting('scale', 2)
      ->setSetting('min', 0)
      //->setSetting('suffix', '€ TTC')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', array(
          'type' => 'number',
          'weight' => 2,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      // The tax amount
      $fields['tax'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('TVA'))
      ->setDescription(t('The tax amount of the Ekiosk entity entity.'))
      ->setSetting('unsigned', TRUE)
      ->setSetting('scale', 2)
      ->setSetting('min', 0)
      //->setSetting('suffix', '€ TTC')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', array(
          'type' => 'number',
          'weight' => 3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      // The total price
      $fields['total_price'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Prix total'))
      ->setDescription(t('The total price of the Ekiosk entity entity.'))
      ->setSetting('unsigned', TRUE)
      ->setSetting('scale', 2)
      ->setSetting('min', 0)
      //->setSetting('suffix', '€ TTC')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', array(
          'type' => 'number',
          'weight' => 4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}
