<?php

namespace Drupal\advertisement\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AdvertisementEntityTypeForm.
 */
class AdvertisementEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $advertisement_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $advertisement_entity_type->label(),
      '#description' => $this->t("Label for the Advertisement entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $advertisement_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\advertisement\Entity\AdvertisementEntityType::load',
      ],
      '#disabled' => !$advertisement_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $advertisement_entity_type = $this->entity;
    $status = $advertisement_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Advertisement entity type.', [
          '%label' => $advertisement_entity_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Advertisement entity type.', [
          '%label' => $advertisement_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($advertisement_entity_type->toUrl('collection'));
  }

}
