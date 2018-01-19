<?php

namespace Drupal\dap_region_switcher\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SwitcherBlock' block.
 *
 * @Block(
 *  id = "switcher_block",
 *  admin_label = @Translation("Region and language switcher block"),
 * )
 */
class SwitcherBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new SwitcherBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $markup = '';

    $currentCountry = \Drupal::service('domain.negotiator')->getActiveDomain();
    $currentCountry = $currentCountry->get('name');

    $countryList = \Drupal::service('domain.loader')->loadOptionsList();
    // $countryList = implode(', ', $countryList);

    $langPrefixes = \Drupal::config('language.negotiation')->get('url.prefixes');
    $langPrefixes = implode(', ', $langPrefixes);

    // $markup .= $currentCountry . ' | ';
    // $markup .= $countryList . ' | ';
    // $markup .= $langPrefixes;

    $host = \Drupal::request()->getHost();
    $currentPath = \Drupal::service('path.current')->getPath();
    $currentLang = \Drupal::languageManager()->getCurrentLanguage()->getId();

    // $currentUrl = $host .'/'. strtolower($currentCountry) .'/'. $currentLang . $currentPath;
    // $markup .= ' | '. $currentUrl;

    $domains = array();
    foreach ($countryList as $country) {
      $domains[$country] = $host .'/'. strtolower($country) .'/'. $currentLang . $currentPath;
    }

    $markup .= implode('<br>', $domains);

    $build = [];
    $build['switcher_block']['#markup'] = $markup;

    return $build;
  }

}
