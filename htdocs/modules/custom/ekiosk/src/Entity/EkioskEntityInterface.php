<?php

namespace Drupal\ekiosk\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Ekiosk entity entities.
 *
 * @ingroup ekiosk
 */
interface EkioskEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Ekiosk entity name = isuue number
   *
   * @return string
   *   Name of the Ekiosk entity.
   */
  public function getName();

  /**
   * Sets the Ekiosk entity name.
   *
   * @param string $name
   *   The Ekiosk entity name.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setName($name);

  /**
   * Gets the Ekiosk entity cover image. CUSTOM
   *
   * @return string
   *   Cover file of the Ekiosk entity.
   */
  public function getCover_image();

  /**
   * Sets the Ekiosk entity cover image. CUSTOM
   *
   * @param string $cover_file
   *   The Ekiosk entity cover file.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setCover_image($cover_image);

  /**
   * Gets the Ekiosk entity issue date. CUSTOM
   *
   * @return string
   *   Start of the Ekiosk entity.
   */
  public function getDate();

  /**
   * Sets the Ekiosk entity issue date. CUSTOM
   *
   * @param string $date
   *   The Ekiosk entity isuue date.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setDate($date);

  /**
   * Gets the Ekiosk entity Flipbook link. CUSTOM
   *
   * @return string
   *   Flipbook link of the Ekiosk entity.
   */
  public function getFlipbook_link();

  /**
   * Sets the Ekiosk entity Flipbook link. CUSTOM
   *
   * @param string $flipbook link
   *   The Ekiosk entity Flipbook link.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setFlipbook_link($flipbook_link);

  /**
   * Gets the Ekiosk entity price HT. CUSTOM
   *
   * @return string
   *   The price HT of the Ekiosk entity.
   */
  public function getPrice_ht();

  /**
   * Sets the Ekiosk entity price HT. CUSTOM
   *
   * @param string $price_ht
   *   The Ekiosk entity price HT.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setPrice_ht($price_ht);

  /**
   * Gets the Ekiosk entity tax amount. CUSTOM
   *
   * @return string
   *   The atx amount of the Ekiosk entity.
   */
  public function getTax();

  /**
   * Sets the Ekiosk entity tax amount. CUSTOM
   *
   * @param string $tax
   *   The Ekiosk entity tax amount.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setTax($tax);

  /**
   * Gets the Ekiosk entity total price. CUSTOM
   *
   * @return string
   *   The total price of the Ekiosk entity.
   */
  public function getTotal_price();

  /**
   * Sets the Ekiosk entity total price. CUSTOM
   *
   * @param string $total_price
   *   The Ekiosk entity total price.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setTotal_price($total_price);



  /**
   * Gets the Ekiosk entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Ekiosk entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Ekiosk entity creation timestamp.
   *
   * @param int $timestamp
   *   The Ekiosk entity creation timestamp.
   *
   * @return \Drupal\ekiosk\Entity\EkioskEntityInterface
   *   The called Ekiosk entity entity.
   */
  public function setCreatedTime($timestamp);

}
