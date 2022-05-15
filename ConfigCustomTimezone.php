<?php

/**
 * @file
 * This is the module for timezone data.
 */

namespace Drupal\timezone_config\Form\Config;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigCustomTimezone.
 *
 * @package Drupal\timezone_config\Form\Config
 */
class ConfigCustomTimezone extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'timezone_config.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'timezone_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $site_config = $this->config('timezone_config.settings');

    $options = [
      'America/Chicago' => 'Chicago',
      'America/New_York' => 'New York',
      'Asia/Tokyo' => 'Tokyo',
      'Asia/Dubai' => 'Dubai',
      'Asia/Kolkata' => 'Kolkata',
      'Europe/Amsterdam' => 'Amsterdam',
      'Europe/Oslo' => 'Oslo',
      'Europe/London' => 'London',
    ]; 

    $form['timezone'] = [
      '#type' => 'select',
      '#options' => $options,
      '#title' => $this->t('TimeZone'),
      '#required' => TRUE,
      '#default_value' => $site_config->get('timezone'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#default_value' => $site_config->get('city'),
    ];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#default_value' => $site_config->get('country'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save config values.
    $this->config('timezone_config.settings')
      ->set('timezone', $form_state->getValue('timezone'))
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
