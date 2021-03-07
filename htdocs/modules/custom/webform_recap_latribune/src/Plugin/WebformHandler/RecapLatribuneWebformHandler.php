<?php
namespace Drupal\webform_recap_latribune\Plugin\WebformHandler;

/**
 * Docs : https://drupal.stackexchange.com/questions/246537/programmatically-update-webform-submission-by-sid/246567
 * https://www.drupal.org/docs/8/modules/webform/webform-cookbook/how-to-track-webform-element-create-update-and-delete
 * https://drupal.stackexchange.com/questions/269182/trigger-emails-handlers-on-webform-submissions-update
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Check if the submitted name + nim are recognised in Eudonet
 * Connecting with Eudonet API
 *
 * @WebformHandler(
 *   id = "Recap_Latribune",
 *   label = @Translation("Recap Latribune"),
 *   category = @Translation("Recap Latribune"),
 *   description = @Translation("Check nom and nim after a webform submission in Eudonet - Create a page of issues."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */

class RecapLatribuneWebformHandler extends WebformHandlerBase {

  /**
   * 3 checks to perform
   * Name and nim in Eudonet database and TR subscriber
   * End number of the issue higher than start number
   * Not further than 24 issues
   *
   */
  public function validateForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {

    //global $nom, $nim, $beginning, $ending, $attitude_tribune;
    $attitude_tribune = '';

    // Check nim and name with Eudonet database +  get start and end values
    if ($form_state->getValue('nom') !== null
        && $form_state->getValue('nim') !== null) {
          $nom = $form_state->getValue('nom');
          $nim = $form_state->getValue('nim');
          $beginning = $form_state->getValue('a_partir_du_numero');
          $ending = $form_state->getValue('jusqu_au_numero');
          // other items needed in the notification email (if not subscriber)
          $prenom = $form_state->getValue('prenom');
          $nim = $form_state->getValue('nim');
          $cp = $form_state->getValue('code_postal');
          $email = $form_state->getValue('email');


       // Checking if the values of 'a_partir_du_numero' and 'jusqu_au_numero' are correct
       if (intval($beginning) >= intval($ending)) {
         $message = "Le numéro de fin est antérieur au numéro de début pour ce récapitulatif. Merci de les inverser";
         $form_state->setErrorByName('jusqu_au_numero', $this->t($message));
       }

       // max 24 mois
       if (intval($ending) - intval($beginning) > 24) {
         $message = "Le récapitulatif ne peut être établi que sur les 24 derniers mois maximum. Merci de corriger";
         $form_state->setErrorByName('jusqu_au_numero', $this->t($message));
       }

       // checking that the nim exists and that the submitted name is matching with the name in Eudonet
       // + getting the content of the field 'Attitude UP'
       require_once ( DRUPAL_ROOT . '/eudonet_api/attitude_tribune/1_attitude_tribune_process.php');
       //debug :
       // $form_state->setErrorByName('nim', $attitude_tribune);

       if (isset($attitude_tribune)) {
         $_SESSION['attitude_tribune'] = $attitude_tribune;;
       }
     }

     // if there's one, we use the error code to display the adequate message
     if (isset($error) && $error != '') {
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
         $form_state->setErrorByName('nim', $this->t('Ce nim est en double dans notre base. Il devrait être unique.<br>
                                                      L\'admin a été prévenu et le problème sera rapidement réglé.'));
           require_once ( DRUPAL_ROOT . '/eudonet_api/attitude_tribune/send_mail_admin.php');
         }

       if ($error == 'no match with name') {
         $message = "Le nim et le nom ne correspondent pas.<br>
		                 Merci de contacter <a href='http://culturepresse.fr/contacts-culture-presse'>votre délégation régionale</a><br>
	                   ";
         $form_state->setErrorByName('nom', $this->t('Le nim et le nom ne correspondent pas.'));
       }

       if ($error == 'technical problem') {
         $message = "Un problème technique nous empêche d'accéder à notre base.<br>
		                Merci de contacter <a href='http://culturepresse.fr/contacts-culture-presse'>votre délégation régionale</a><br>
	                  ";
         $form_state->setErrorByName('nom', $this->t('Un problème technique nous empêche d\'accéder à notre base.'));
       }
     }
  }
}
