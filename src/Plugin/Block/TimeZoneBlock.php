<?php

/**
 * @file
 * This is the module for timezone data.
 */

namespace Drupal\timezone_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\timezone_config\Services\TimeZoneServices;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a block with a TimeZone.
 *
 * @Block(
 *   id = "time_zone_block",
 *   admin_label = @Translation("TimeZone Block"),
 * )
 */
class TimeZoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * To get timezone from services.
   *
   * @var \Drupal\timezone_config\Services\TimeZoneServices
   */
  protected $customTimeZone;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Class constructor.
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\timezone_config\Services\TimeZoneServices $customTimeZone
   *    To get timezone from services
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeZoneServices $customTimeZone , ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timezone = $customTimeZone;
    $this->configFactory = $configFactory;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('timezone.timezone_service'),
      $container->get('config.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('timezone_config.settings');
    $city = $config->get('city');
    $country = $config->get('country');
    $date = $this->timezone->getData();
    return [
      '#theme' => 'custom_timezone_block',
      '#date' => $date,
      '#city' => $city,
      '#country' => $country,
      '#cache' => ['max-age' => 0],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
      return 0;
  }

}
