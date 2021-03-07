<?php

/**
 * @file
 * Contains \Drupal\advertisement\src\Plugin\Block\AdvertisementBannerBlock
 */
namespace Drupal\advertisement\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;

/**
 * Provides an Advertisement Banner Block
 * @Block(
 *   id = "advertisement_banner_block",
 *   admin_label = @Translation("Banner Block"),
 *   category = @Translation("Banner Block"),
 *   )
 */

class AdvertisementBannerBlock extends BlockBase {

  /**
   * Get Banners in database if there are
   * If more than 1, display each one after the other, picked at random
   * the date only config means all days are valid at 00h00
   */
  public function build() {

    $today = date('Y-m-d');

    // check if there are banners in the database
    $query = \Drupal::entityQuery('advertisement_entity');
    $query->condition('type', 'banner');
    $query->condition('adv_start', $today, '<=');
    $query->condition('adv_end', $today, '>=');

    $entity_ids = $query->execute();
    // kint($entity_ids);

    if ($entity_ids) {
      // $banners = AdvertisementEntity::loadMultiple($banners);
      $banners = \Drupal::entityTypeManager()->getStorage('advertisement_entity')->loadMultiple($entity_ids);
      //kint($banners);

      $random_banner = array_rand($banners, 1);
      $picked_banner = $banners[$random_banner];
      // kint($picked_banner) ;

      $id = $picked_banner->get('id')->value;
      $name = $picked_banner->get('name')->value;
      $file = $picked_banner->get('adv_file')->target_id; // => managed_file id
      $size = $picked_banner->get('field_adv_size')->value;
      $url = Url::fromUri($picked_banner->get('adv_link')->value);

      // get the width and the height of the banner from the size
      $tab = explode('x', $size);
      $width = $tab[0] . 'px';
      $height = $tab[1] . 'px';

      // get the adress of the image file
      $ad = File::load($file);
      $source = $ad->getFileUri(); // public://...
      // kint($source);

      return array(
        '#theme' => 'advertisement-banner-block',
        '#width' => $width,
        '#height' => $height,
        '#uri' => $source,
        '#link' => $url,
        '#name' => $name,
      );
    }
  }

  /**
   * Disabling the block caching
   */
  public function getCacheMaxAge() {
    return 0;
  }

}