<?php


namespace Drupal\timezone_blocks\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TimezoneTimeBlock
 *
 * @package Drupal\timezone_blocks\Plugin\Block
 *
 * @Block(
 *   id = "timezone_time",
 *   admin_label="Timezone Time",
 * )
 */
class TimezoneTimeBlock extends BlockBase implements BlockPluginInterface {

  /**
   * @return array
   */
  public function build() {
    $config = $this->getConfiguration();
    $timezone_identifiers = \DateTimeZone::listIdentifiers();
    $timezone = $timezone_identifiers[$config['timezone']];
    $time = \Drupal\Core\Datetime\DrupalDateTime::createFromTimestamp(time(), new \DateTimeZone($timezone))->format('G:i');
    return [
      '#markup' => 'Je právě ' . $time
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['timezone'] = [
      '#type' => 'select',
      '#options' => \DateTimeZone::listIdentifiers(),
      '#title' => $this->t('Timezone'),
      '#description' => $this->t('Select timezone to display time for'),
      '#default_value' => isset($config['timezone']) ? $config['timezone'] : ''
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['timezone'] = $values['timezone'];
  }

}
