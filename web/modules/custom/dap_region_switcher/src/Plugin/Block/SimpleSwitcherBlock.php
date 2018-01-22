<?php

namespace Drupal\dap_region_switcher\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SimpleSwitcherBlock' block.
 *
 * @Block(
 *  id = "simple_switcher_block",
 *  admin_label = @Translation("Region and language simplee switcher block"),
 * )
 */
class SimpleSwitcherBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
    $currentCountry = \Drupal::service('domain.negotiator')->getActiveDomain();
    $currentCountry = $currentCountry->id();
    // $currentCountry = $currentCountry->get('name');

    $countryList = \Drupal::service('domain.loader')->loadOptionsList();

    // $langPrefixes = \Drupal::config('language.negotiation')->get('url.prefixes');

    $scheme = \Drupal::request()->getScheme();
    $host = \Drupal::request()->getHost();
    // $currentPath = \Drupal::service('path.current')->getPath();
    // $currentLang = \Drupal::languageManager()->getCurrentLanguage()->getId();

    $langs = array(
      'deu' => 'de',
      'gbr' => 'en',
      'usa' => 'en-us',
    );

    $domains = array();
    foreach ($countryList as $cid => $country) {
      $lang = $langs[$cid];
      if ($cid === $currentCountry) {
        $domains[$country] = '<li class="tabs__tab"><span>'. $country .'</span></li>';
      }
      else {
        $domains[$country] = '<li class="tabs__tab"><a href="'. $scheme . '://'. $host .'/'. $cid .'/'. $lang .'">'. $country .'</a></li>';
      }
    }

    $markup = '<div class="is-horizontal"><ul class="nav tabs nav-tabs secondary clearfix">'. implode(' ', $domains) .'</ul></div>';

    $build = [];
    $build['#cache']['max-age'] = 0;
    $build['switcher_block']['#markup'] = $markup;

    return $build;
  }

}
