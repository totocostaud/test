<?php

namespace Drupal\cookies\Services;

use Drupal\Core\Asset\LibraryDiscoveryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Url;
use Drupal\language\ConfigurableLanguageManagerInterface;

/**
 * Class CookiesConfigService.
 */
class CookiesConfigService {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\language\ConfigurableLanguageManagerInterface definition.
   *
   * @var \Drupal\language\ConfigurableLanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Service groups.
   *
   * @var array
   */
  protected $serviceGroups;

  /**
   * Library discovery service.
   *
   * @var \Drupal\Core\Asset\LibraryDiscoveryInterface
   */
  protected $libraryDiscovery;

  /**
   * The base cookie configuration.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $cookiesConfig;


  /**
   * The base cookie configuration.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * The base library where cookiejsr-preloader.js is load from.
   *
   * @var string
   */
  protected $baseLibrary;

  /**
   * Constructs a new CookiesConfigService object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory, ConfigurableLanguageManagerInterface $language_manager, LibraryDiscoveryInterface $library_discovery, LoggerChannelInterface $logger) {
    $this->entityTypeManager = $entity_type_manager;
    $this->languageManager = $language_manager;
    $this->libraryDiscovery = $library_discovery;

    $this->configFactory = $config_factory;
    $this->cookiesConfig = $this->configFactory->get('cookies.config');
    $this->logger = $logger;
  }

  /**
   * Returns the complete formatted Cookies JSR configuration.
   *
   * @param null|string $langId
   *   Optional parameter.
   *
   * @return array
   *   Complete formatted Cookies JSR configuration.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getCookiesConfig($langId = NULL) {
    // Pre-config language to deliver.
    $current_language = $this->languageManager->getCurrentLanguage();
    $langId = (!$langId) ? $current_language->getId() : $langId;
    $language = $this->languageManager->getLanguage($langId);
    $this->languageManager->setConfigOverrideLanguage($language);

    $service_groups = $this->getGroups();
    $ui_translation = $this->getTranslation($language);

    $group_translation = $this->getGroupTranslation(array_keys($service_groups));

    // Reset language to default.
    $this->languageManager->setConfigOverrideLanguage($current_language);

    return [
      "config" => $this->getConfig(),
      "services" => $service_groups,
      "translation" => array_merge($ui_translation, $group_translation),
    ];

  }

  /**
   * Tests if the Cookies JSR library is installed in the correct folder.
   *
   * @return bool
   *   Test result if the library is installed correct.
   */
  protected function libraryExists() {
    $lib = $this->libraryDiscovery->getLibraryByName('cookies', 'cookiesjsr');
    if (!$lib) {
      return FALSE;
    }
    foreach ($lib['js'] as $js_file) {
      if (isset($js_file['data']) && $js_file['data']) {
        return file_exists(DRUPAL_ROOT . '/' . $js_file['data']);
      }
    }
    return FALSE;
  }

  /**
   * Returns the library to use (cdn or from library folder).
   *
   * @return string
   *   The library id as defined in the cookies.libraries.yml.
   */
  public function getLibrary() {
    if ($this->baseLibrary) {
      return $this->baseLibrary;
    }
    $loadCDN = (bool) $this->cookiesConfig->get('lib_load_from_cdn');
    if (!$loadCDN) {
      if ($this->libraryExists()) {
        return $this->baseLibrary = 'cookies/cookiesjsr';
      }
      $this->logger->error('Library still loads from CDN. You disabled to load Cookies JSR from CDN but you didn\'t installed the library locally. Please Download the library with Version >=1.0.3 from github (https://github.com/jfeltkamp/cookiesjsr/tree/1.0.3) and place it in the libraries folder ({docroot}/libraries/cookiesjsr/dist/cookiesjsr-preloader.min.js to reach the loader script.)');
    }
    return $this->baseLibrary = 'cookies/cookiesjsr.cdn';
  }

  /**
   * Returns the URL path from where the library is delivered.
   *
   * @return string
   *   Return library URL without file specification (fallback to CDN).
   */
  public function getLibraryUrl() {
    $libId = explode('/', $this->getLibrary());
    $lib = $this->libraryDiscovery->getLibraryByName($libId[0], $libId[1]);
    foreach ($lib['js'] as $js_file) {
      $libUrl = explode('/', $js_file['data']);
      array_pop($libUrl);
      $base = ($libId[1] != 'cookiesjsr.cdn') ? base_path() : '';
      return $base . implode('/', $libUrl);
    }
    return 'https://cdn.jsdelivr.net/gh/jfeltkamp/cookiesjsr@1/dist';
  }

  /**
   * Returns the configuration object for Cookies JSR.
   *
   * @return array[]
   *   Configuration object.
   */
  protected function getConfig() {
    $config = $this->cookiesConfig;

    $expires = (int) $config->get('cookie_expires');
    $expires = ($expires) ? $expires : 30;
    $expires = $expires * 24 * 60 * 60 * 1000;
    $callback = (!$config->get('use_callback')) ? [] : [
      "method" => $config->get('callback_method'),
      "url" => $config->get('callback_url'),
      "headers" => [],
    ];

    $availableLangs = [];
    foreach ($this->languageManager->getLanguages() as $key => $lang) {
      $availableLangs[] = $key;
    }
    $defaultLang = $this->languageManager->getDefaultLanguage()->getId();

    $libPath = $this->getLibraryUrl();

    return [
      "cookie" => [
        "name" => $config->get('cookie_name'),
        "expires" => $expires,
        "domain" => $config->get('cookie_domain'),
        "sameSite" => $config->get('cookie_same_site'),
        "secure" => (bool) $config->get('cookie_secure'),
      ],
      "library" => [
        "libBasePath" => $libPath,
        "libPath" => $libPath . '/cookiesjsr.min.js',
        "scrollLimit" => (int) $config->get('lib_scroll_limit'),
        "timeoutApp" => (int) $config->get('lib_timeout'),
      ],
      "callback" => $callback,
      "interface" => [
        "openSettingsHash" => "#{$config->get('open_settings_hash')}",
        "showDenyAll" => (bool) $config->get('show_deny_all'),
        "settingsAsLink" => (bool) $config->get('settings_as_link'),
        "availableLangs" => $availableLangs,
        "defaultLang" => $defaultLang,
        "groupConsent" => (bool) $config->get('group_consent'),
        "cookieDocs" => (bool) $config->get('cookie_docs'),
      ],
    ];
  }

  /**
   * Lazy loader for service groups.
   *
   * @return array|\Drupal\Core\Entity\EntityInterface[]
   *   Service groups.
   */
  protected function getServiceGroups() {
    if (!$this->serviceGroups) {
      try {
        $this->serviceGroups = $this->entityTypeManager->getStorage('cookies_service_group')->loadMultiple();
      }
      catch (\Exception $exception) {
        // @codingStandardsIgnoreStart
        // Disabled PHPCS warning because this is just an exception.
        \Drupal::logger('cookies')->error($exception->getMessage());
        // @codingStandardsIgnoreEnd
      }
    }
    return $this->serviceGroups;
  }

  /**
   * Returns a single cookie_service_group entity by ID.
   *
   * @param string $group
   *   Group seeking for.
   *
   * @return bool|\Drupal\Core\Entity\EntityInterface
   *   Return group Entity or false if none exists.
   */
  protected function getGroup($group) {
    $groups = $this->getServiceGroups();
    return ($groups && isset($groups[$group])) ? $groups[$group] : FALSE;
  }

  /**
   * Get weight of a group for sort order.
   *
   * @param string $group
   *   Group seeking for.
   *
   * @return int
   *   The group weight
   */
  protected function getGroupWeight($group) {
    $group = $this->getGroup($group);
    return ($group) ? (int) $group->get('weight') : 99;
  }

  /**
   * Compare function to sort by weight.
   *
   * @param int $a
   *   Compare param.
   * @param int $b
   *   Compare param.
   *
   * @return int|\lt
   *   Result of comparison.
   */
  protected function sortWeight($a, $b) {
    return strcmp($a['weight'], $b['weight']);
  }

  /**
   * Returns the complete groups config.
   *
   * @return array
   *   Complete groups config
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getGroups() {
    $service_entities = $this->entityTypeManager
      ->getStorage('cookies_service')
      ->loadByProperties(['status' => 1]);
    $services = [];
    foreach ($service_entities as $s_entity) {
      /** @var $s_entity CookiesServiceEntity */
      $group = $s_entity->get('group');
      if (!isset($services[$group])) {
        $services[$group] = [
          "id" => $group,
          "services" => [],
          "weight" => $this->getGroupWeight($group),
        ];
      }
      $services[$group]["services"][] = [
        "key" => $s_entity->id(),
        "type" => $s_entity->get('group'),
        "name" => $s_entity->label(),
        "uri" => $s_entity->get('url'),
        "needConsent" => $s_entity->get('consent'),
      ];
    }

    uasort($services, [$this, "sortWeight"]);
    return $services;
  }

  /**
   * Returns translations of groups title and details.
   *
   * @param array $group_ids
   *   Collected group ids.
   *
   * @return array
   *   Returns array with group translation.
   */
  protected function getGroupTranslation(array $group_ids) {
    $translation = [];
    foreach ($group_ids as $group_id) {
      if ($group = $this->getGroup($group_id)) {
        $translation[$group_id] = [
          "title" => $group->get('title'),
          "details" => $group->get('details'),
        ];
      };
    }
    return $translation;
  }

  /**
   * Get UI translation.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language the translation is to deliver.
   *
   * @return array|mixed
   *   Complete translation of the config cookies.texts.
   */
  protected function getTranslation(LanguageInterface $language) {
    $config = $this->configFactory->get('cookies.texts')->get();
    $uris = ['privacyUri', 'imprintUri', 'cookieDocsUri'];
    foreach ($uris as $uri) {
      if (preg_match('/\/node\/([0-9]*)$/', $config[$uri], $matches)) {
        $url = Url::fromRoute('entity.node.canonical', ['node' => $matches[1]], ['language' => $language]);
        $config[$uri] = $url->toString(TRUE)->getGeneratedUrl();
      }
    }
    return $config;
  }

}
