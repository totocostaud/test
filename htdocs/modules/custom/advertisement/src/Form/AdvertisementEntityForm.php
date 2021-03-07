<?php

namespace Drupal\advertisement\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Advertisement entity edit forms.
 *
 * @ingroup advertisement
 */
class AdvertisementEntityForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * Constructs a new AdvertisementEntityForm.
   *
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository service.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current user account.
   */
  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, AccountProxyInterface $account) {
    parent::__construct($entity_repository, $entity_type_bundle_info, $time);

    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      $container->get('entity.repository'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var \Drupal\advertisement\Entity\AdvertisementEntity $entity */
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   * If the advertisement is an interstitial, save a splashify entity in the same time
   *
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    // If type = interstitial, get the content and create an interstitial page
    if ($entity->bundle() == 'interstitial') {
      $name = $entity->getName();

      $file = $form_state->getValue('adv_file');
      $ad = File::load($file[0]['fids'][0]);
      $source = file_create_url($ad->getFileUri());

      $array_link = $form_state->getValue('adv_link');
      $link = $array_link[0]['value'];

      create_page($name, $source, $link);
    }

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Advertisement entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Advertisement entity.', [
          '%label' => $entity->label(),
        ]));
    }

    $form_state->setRedirect('entity.advertisement_entity.canonical', ['advertisement_entity' => $entity->id()]);
  }
}

function create_page($name, $source, $link) {

	// Navigating to the right directory /files/images/advertisement/interstitial_pages
	// by default, we're in Drupal root directory
	chdir('./sites/default/files/images/advertisement/interstitial_pages/');

	if( file_exists("interstitial.html") ) {
		unlink("interstitial.html");

		$messenger= \Drupal::messenger();
        $message = 'Remplacement du fichier précédent';
        $messenger->addMessage($message, 'success');
	}

	// Creating the file
	$handle = fopen("interstitial.html", 'a+');

	// changing the source (absolute url) in a relative url to be able to open in the colorbox
	global $base_url;
	$relative_source =  str_ireplace ($base_url, '' , $source);
    $content = '<a target="_blank" href="' . $link . '"><img src="'. $relative_source .'" alt="' . $name . '" style="width:800px; height:600px;"></a>';

    $data = '<html><body>';
    $data .= $content;
    $data .= '</body></html>';

	fwrite($handle, $data);
	fclose($handle);

    $messenger= \Drupal::messenger();
    $message = 'Interstitiel enregistré';
    $messenger->addMessage($message, 'success');


}