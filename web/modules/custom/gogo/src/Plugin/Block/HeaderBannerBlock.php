<?php

namespace Drupal\gogo\Plugin\Block;

use Drupal\block\Entity\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * Provides a 'HeaderBannerBlock' block.
 *
 * @Block(
 *  id = "header_banner_block",
 *  admin_label = @Translation("Header Banner"),
 * )
 */
class HeaderBannerBlock extends BlockBase {

  /**
   * Returns a clean data structure used for quering the entities.
   */
  private static function getEmptyDataStruct() {
    return [
      'title' => '',
      'image' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $data = self::getEmptyDataStruct();
    if (\Drupal::service('path.matcher')->isFrontPage()) {
      return;
    }
    $status = \Drupal::requestStack()->getCurrentRequest()->attributes->get('exception');
    if ($status && $status->getStatusCode() == 404) {
      return;
    }
    $ctx = [
      'node' => \Drupal::routeMatch()->getParameter('node'),
    ];
    if ($ctx['node']) {
      $data['title'] = $ctx['node']->getTitle();
    }
    return [
      '#theme' => 'header_banner',
      '#image' => $data['image'],
      '#title' => $data['title'],
      '#cache' => [
        'contexts' => ['url.path'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
