<?php

namespace Drupal\cookies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ServiceConfigController.
 */
class LangController extends ControllerBase {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->configFactory = $container->get('config.factory');
    return $instance;
  }

  /**
   * Getservices.
   *
   * @return string
   *   Return Hello string.
   */
  public function getTranslation($lang_id) {
    $options = [
      "bannerText" => "We use a selection of our own and third-party cookies on the pages of this website: Essential cookies, which are required in order to use the website; functional cookies, which provide better easy of use when using the website; performance cookies, which we use to generate aggregated data on website use and statistics; and marketing cookies, which are used to display relevant content and advertising. If you choose \"ACCEPT COOKIES\", you consent to the use of all cookies. You can accept and reject individual cookie types and  revoke your consent for the future at any time under \"Cookie settings\".",
      "settings" => "Settings",
      "acceptAll" => "Accept all",
      "close" => "Close",
      "settingsAllServices" => "Settings for all services",
      "allowed" => "allowed",
      "denied" => "denied",
      "readMore" => "Read more",
      "officialWebsite" => "View the official website",
      "cookieSettings" => "Cookie settings",
      "allowAll" => "Accept all",
      "denyAll" => "Deny all",
      "saveSettings" => "Save",
      "privacyPolicy" => "Privacy policy",
      "imprint" => "Imprint",
      "imprintUri" => "/imprint",
      "privacyUri" => "/privacy",
      "credit" => "",
      "default" => [
        "title" => "What are cookies?",
        "details" => "Cookies are small text files that are placed by your browser on your device in order to store certain information. Using the information that is stored and returned, a website can recognize that you have previously accessed and visited it using the browser on your end device. We use this information to arrange and display the website optimally in accordance with your preferences. Within this process, only the cookie itself is identified on your device. Personal data is only stored following your express consent or where this is absolutely necessary to enable use the service provided by us and accessed by you.",
      ],
      "ads" => [
        "title" => "Advertising network",
        "details" => "Ad networks can generate revenue by selling advertising space on the site.",
      ],
      "analytic" => [
        "title" => "Marketing cookies",
        "details" => "Marketing cookies come from external advertising companies (\"third-party cookies\") and are used to collect information about the websites visited by the user. The purpose of this is to create and display target group-oriented content and advertising for the user.",
      ],
      "social" => [
        "title" => "Social networks",
        "details" => "Social networks can improve the usability of the site and help to promote it via the shares.",
      ],
      "video" => [
        "title" => "Videos",
        "details" => "Video sharing services help to add rich media on the site and increase its visibility.",
      ],
      "comment" => [
        "title" => "Comments",
        "details" => "Comments managers facilitate the filing of comments and fight against spam.",
      ],
      "support" => [
        "title" => "Support",
        "details" => "Support services allow you to get in touch with the site team and help to improve it.",
      ],
      "api" => [
        "title" => "Performance cookies",
        "details" => "Performance cookies collect aggregated information about how our website is used. The purpose of this is to improve its attractiveness, content and functionality. These cookies help us to determine whether, how often and for how long particular sub-pages of our website are accessed and which content users are particularly interested in. Search terms, country, region and (where applicable) the city from which the website is accessed are also recorded, as is the proportion of mobile devices that are used to access the website. We use this information to compile statistical reports that help us tailor the content of our website to your needs and optimize our offer.",
      ],
      "other" => [
        "title" => "Other",
        "details" => "Services to display web content.",
      ],
    ];;
    return new JsonResponse($options);
  }

}
