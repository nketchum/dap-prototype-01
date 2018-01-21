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

    $build = [];
    $build['switcher_block']['#markup'] = $markup;

    return $build;
  }

}
