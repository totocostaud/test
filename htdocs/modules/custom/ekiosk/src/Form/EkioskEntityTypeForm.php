<?php

namespace Drupal\ekiosk\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EkioskEntityTypeForm.
 */
class EkioskEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $ekiosk_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
        '#default_value' => $ekiosk_entity_type->label(),
      '#description' => $this->t("Label for the Ekiosk entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
        '#default_value' => $ekiosk_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\ekiosk\Entity\EkioskEntityType::load',
      ],
        '#disabled' => !$ekiosk_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ekiosk_entity_type = $this->entity;
    $status = $ekiosk_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Ekiosk entity type.', [
        '%label' => $ekiosk_entity_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Ekiosk entity type.', [
        '%label' => $ekiosk_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($ekiosk_entity_type->toUrl('collection'));
  }

}
