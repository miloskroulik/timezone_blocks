<?php


namespace Drupal\timezone_blocks\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;

class TimezoneDeriver extends DeriverBase {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $timezone_identifiers = \DateTimeZone::listIdentifiers();
    foreach ($timezone_identifiers as $key => $timezone) {
      print '';
      $this->derivatives[$key] = $base_plugin_definition;
      $this->derivatives[$key]['admin_label'] = t('Timezone block: ') . $timezone;
    }
    return $this->derivatives;
  }
}
