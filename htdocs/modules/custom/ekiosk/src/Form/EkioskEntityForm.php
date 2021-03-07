<?php

namespace Drupal\ekiosk\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Ekiosk entity edit forms.
 *
 * @ingroup ekiosk
 */
class EkioskEntityForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * Constructs a new EkioskEntityForm.
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
    /* @var \Drupal\ekiosk\Entity\EkioskEntity $entity */
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   * Create a Access page to the flipbook
   *
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    if ($entity->bundle() == 'normal') {
      $name = $entity->getName();

      $array_flipbook_link = $form_state->getValue('flipbook_link');
      $flipbook_link = $array_flipbook_link[0]['value'];

      create_flipbook_page($name, $flipbook_link);
    }

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Ekiosk entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Ekiosk entity.', [
          '%label' => $entity->label(),
        ]));
    }
  }
}

/**
 * Create a page with the iframe code
 * A page in a specific folder with .htaccess allows to control the access
 *
 * @param $name
 *  the issue number wil give the name of the file (ex : 352.htm)
 * @param $landing
 *  the Anyflip url
 *  @param
 *
 */
function create_flipbook_page($name, $flipbook_link) {

  // Navigating to the right directory DRUPAL_ROOT/flipbook (permission 777)
	// by default, we're in Drupal root directory
	chdir( DRUPAL_ROOT . '/flipbook');

	if( file_exists($name . '.htm') ) {
	  unlink($name . '.htm');

		$messenger= \Drupal::messenger();
        $message = 'Remplacement du fichier précédent';
        $messenger->addMessage($message, 'status');
	  }

	  // Creating the file
	  $handle = fopen($name . '.htm', 'a+');

	  // Writing the file
	  $data =
'<!DOCTYPE>
 <html>
  <head>
   <title>UNION PRESSE</title>
  </head>
 <body>
  <iframe style="width:100%;height:100%" src="'.$flipbook_link.'" seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe>
 </body>
</html>';  // END OF DATA

	  fwrite($handle, $data);
	  fclose($handle);

    $messenger= \Drupal::messenger();
    $message = 'Page Flipbook enregistré';
    $messenger->addMessage($message, 'status');

}