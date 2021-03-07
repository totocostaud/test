<?php

namespace Drupal\advertisement\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Advertisement entity entities.
 *
 * @ingroup advertisement
 */
interface AdvertisementEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */


  /**
   * Gets the Advertisement entity start. CUSTOM
   *
   * @return string
   *   Start of the Advertisement entity.
   */
  public function getAdv_start();

  /**
   * Sets the Advertisement entity start. CUSTOM
   *
   * @param string $start
   *   The Advertisement entity start.
   *
   * @return \Drupal\advertisement\Entity\AdvertisementEntityInterface
   *   The called Advertisement entity entity.
   */
  public function setAdv_start($start);

  /**
   * Gets the Advertisement entity start. CUSTOM
   *
   * @return string
   *   Start of the Advertisement entity.
   */
  public function getAdv_end();

  /**
   * Sets the Advertisement entity start. CUSTOM
   *
   * @param string $start
   *   The Advertisement entity start.
   *
   * @return \Drupal\advertisement\Entity\AdvertisementEntityInterface
   *   The called Advertisement entity entity.
   */
  public function setAdv_end($end);

  /**
   * Gets the Advertisement entity link. CUSTOM
   *
   * @return string
   *   Link of the Advertisement entity.
   */
  public function getAdv_link();

  /**
   * Sets the Advertisement entity link. CUSTOM
   *
   * @param string $link
   *   The Advertisement entity link.
   *
   * @return \Drupal\advertisement\Entity\AdvertisementEntityInterface
   *   The called Advertisement entity entity.
   */
  public function setAdv_link($ad_link);

  /**
   * Gets the Advertisement entity file. CUSTOM
   *
   * @return string
   *   File of the Advertisement entity.
   */
  public function getAdv_file();

  /**
   * Sets the Advertisement entity link. CUSTOM
   *
   * @param string $file
   *   The Advertisement entity file.
   *
   * @return \Drupal\advertisement\Entity\AdvertisementEntityInterface
   *   The called Advertisement entity entity.
   */
  public function setAdv_file($ad_file);


  /**
   * Gets the Advertisement entity name.
   *
   * @return string
   *   Name of the Advertisement entity.
   */
  public function getName();

  /**
   * Sets the Advertisement entity name.
   *
   * @param string $name
   *   The Advertisement entity name.
   *
   * @return \Drupal\advertisement\Entity\AdvertisementEntityInterface
   *   The called Advertisement entity entity.
   */
  public function setName($name);

  /**
   * Gets the Advertisement entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Advertisement entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Advertisement entity creation timestamp.
   *
   * @param int $timestamp
   *   The Advertisement entity creation timestamp.
   *
   * @return \Drupal\advertisement\Entity\AdvertisementEntityInterface
   *   The called Advertisement entity entity.
   */
  public function setCreatedTime($timestamp);

}
