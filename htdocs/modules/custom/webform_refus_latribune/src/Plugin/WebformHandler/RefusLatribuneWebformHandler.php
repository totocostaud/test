<?php
namespace Drupal\webform_refus_latribune\Plugin\WebformHandler;

/**
 * Docs : https://drupal.stackexchange.com/questions/246537/programmatically-update-webform-submission-by-sid/246567
 * https://www.drupal.org/docs/8/modules/webform/webform-cookbook/how-to-track-webform-element-create-update-and-delete
 * https://drupal.stackexchange.com/questions/269182/trigger-emails-handlers-on-webform-submissions-update
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
use FontLib\EOT\File;

/**
 * Check if the submitted name + nim are recognised in Eudonet
 * Connecting with Eudonet API
 *
 * @WebformHandler(
 *   id = "Refus_Latribune",
 *   label = @Translation("Refus Latribune"),
 *   category = @Translation("Refus Latribune"),
 *   description = @Translation("Check nom and nim after a webform submission - register refusal in Eudonet."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */

class RefusLatribuneWebformHandler extends WebformHandlerBase {

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {

    global $nom, $nim;
    /*$depot = '';
    // populate the field 'selected_depot'
    if ($form_state->getValue('depots_region_nord_ouest') !== null )
      || $form_state->getValue('depots_region_nord_est') !== null
      || $form_state->getValue('depots_region_sud_est') !== null
      || $form_state->getValue('depots_region_sud_ouest') !== null
      || $form_state->getValue('depots_region_paris') !== null {


      $depot = $form_state->getValue('depots_region_nord_ouest');
      \Drupal::messenger()->addMessage('NO INLINE ' . $depot, 'status');
      $form_state->setValue('selected_depot', $depot);
    }

    if ($form_state->getValue('depots_region_nord_ouest') !== null ) {
      $depot = $form_state->getValue('depots_region_nord_ouest');
      \Drupal::messenger()->addMessage('NO INLINE ' . $depot, 'status');
      $form_state->setValue('selected_depot', $depot);
    }
    elseif ($form_state->getValue('depots_region_nord_est') !== null ) {
      $depot = $form_state->getValue('depots_region_nord_est');
      \Drupal::messenger()->addMessage('NE INLINE ' . $depot, 'status');
      $form_state->setValue('selected_depot', $depot);
    }
    elseif ($form_state->getValue('depots_region_sud_est') !== null ) {
      $depot = $form_state->getValue('depots_region_sud_est');
      \Drupal::messenger()->addMessage('SE INLINE ' . $depot, 'status');
      $form_state->setValue('selected_depot', $depot);
    }
    elseif ($form_state->getValue('depots_region_sud_ouest') !== null ) {
      $depot = $form_state->getValue('depots_region_sud_ouest');
      \Drupal::messenger()->addMessage('SO INLINE ' . $depot, 'status');
      $form_state->setValue('selected_depot', $depot);
    }
    elseif ($form_state->getValue('depots_region_paris') !== null ) {
      $form_state->setValue('selected_depot', $depot);
      \Drupal::messenger()->addMessage('P INLINE ' . $depot, 'status');
    }
    \Drupal::messenger()->addMessage('fonal' . $depot, 'status');
    if ($depot == 'no') {
      \Drupal::messenger()->addMessage($depot, 'status');
      $form_state->setErrorByName('selected_depot', $this->t('Merci de renseigner le champ \'dépôt\'.'));
    }*/

    // Check nim and name with Eudonet database
    if ($form_state->getValue('nom') !== null
        && $form_state->getValue('nim') !== null) {
          $nom = $form_state->getValue('nom');
          $nim = $form_state->getValue('nim');

          // checking that the nim exists and that the submitted name is the same than in Eudonet
          require_once ( DRUPAL_ROOT . '/eudonet_api/attitude_tribune/1_attitude_tribune_process.php');
        }

        // if $check isn't empty we use the error code to display the adequate message
        if ( isset($error) && $error != '') { // NEW
          if ($error == 'nim unknown') {
            $message = "Votre nim n'est pas reconnu dans notre base.<br>
				              Merci de contacter <a href='http://culturepresse.fr/contacts-culture-presse'>votre délégation régionale</a><br>
	                    ";
            $form_state->setErrorByName('nim', $this->t('Ce nim n\'est pas reconnu dans notre base.'));

          }
          if ($error == 'nim is not unique') {
            $message = "Ce nim est en double dans notre base. Il devrait être unique.<br>
                 Un message est envoyé à l'administrateur pour corriger ce problème.<br>
				         Merci de contacter <a href='http://culturepresse.fr/contacts-culture-presse'>votre délégation régionale</a><br>
	               ";
            //form_error($form['submitted']['nim'], $message);
            $form_state->setErrorByName('nim', $this->t('Ce nim est en double dans notre base. Il devrait être unique.'));

            global $nom, $nim;
            require_once ( DRUPAL_ROOT . '/eudonet_api/unionpresse/attitude_tribune/send_mail_admin.php');
          }

          if ($error == 'no match with name') {
            $message = "Le nim et le nom ne correspondent pas.<br>
				              Merci de contacter <a href='http://culturepresse.fr/contacts-culture-presse'>votre délégation régionale</a><br>
	                    ";
            //form_error($form['submitted']['nom'], $message);
            $form_state->setErrorByName('nom', $this->t('Le nim et le nom ne correspondent pas.'));
          }

          if ($error == 'technical problem') {
            $message = "Un problème technique nous empêche d'accéder à notre base.<br>
				              Merci de contacter <a href='http://culturepresse.fr/contacts-culture-presse'>votre délégation régionale</a><br>
	                    ";
            //form_error($form['submitted']['nom'], $message);
            $form_state->setErrorByName('nom', $this->t('Un problème technique nous empêche d\'accéder à notre base.'));
          }
        }
  }

  /**
   * {@inheritdoc}
   * Function to be fired after submitting the Webform.
   * Calling the custom function which will save the refusal in Eudonet
   */
  // Function to be fired after submitting the Webform.
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {

    // Get an array of the values from the submission.
    $values = $webform_submission->getData();

    global $base_url,$nom, $nim;

    // We update the field 'Attitude_TR' in Eudonet
    global $pp_id;
    $result_update = update_attitude_tr($pp_id);

    // if the update is successful, the Drupal webform process goes on, displaying the landing page with the appropriate message
    // if there'a problem :
      if (isset( $result_update['error'] ) && $result_update['error'] = 'Echec de la mise à jour') {
        // drupal_set_message('Le site a rencontré un problème technique (update). Merci de bien vouloir réessayer ultérieurement', 'error');
        \Drupal::messenger()->addMessage('Le site a rencontré un problème technique (update). Merci de bien vouloir réessayer ultérieurement', 'error');
      }
      else {
        \Drupal::messenger()->addMessage('Votre demande a bien été enregistrée.', 'status');
      }
  }

  /**
   * Display the invoked plugin method to end user.
   *
   * @param string $method_name
   *   The invoked method name.
   * @param string $context1
   *   Additional parameter passed to the invoked method name.
   */
  protected function debug($method_name, $context1 = NULL) {
    if (!empty($this->configuration['debug'])) {
      $t_args = [
          '@id' => $this->getHandlerId(),
          '@class_name' => get_class($this),
          '@method_name' => $method_name,
          '@context1' => $context1,
      ];
      $this->messenger()->addWarning($this->t('Invoked @id: @class_name:@method_name @context1', $t_args), TRUE);
    }
  }

  /**
    * {@inheritdoc}
   */
   public function getSummary() {
     // Broken/missing webform handlers do not need a summary.
     return [];
    }
}

/**
 * Custom function
 * Updating 3 fields in Eudonet table 200
 *
 * @param $pp_id
 * The ID on CONTACTS table
 * @return $result_update
 * Array of results with 2 possible keys : success or error
 */
function update_attitude_tr($pp_id) {
  require_once ( DRUPAL_ROOT . '/eudonet_api/attitude_tribune/3_up_refusal_200_update.php');
  return $result_update;
}

