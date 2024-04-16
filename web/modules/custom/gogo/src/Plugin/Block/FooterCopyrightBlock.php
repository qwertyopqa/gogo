<?php

namespace Drupal\gogo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a footer copyright block.
 *
 * @Block(
 *   id = "gogo_footer_copyright",
 *   admin_label = @Translation("Footer Copyright"),
 *   category = @Translation("Custom")
 * )
 */
class FooterCopyrightBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'copyright' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['copyright'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Copyright'),
      '#description' => $this->t('You can use [year] as a placeholder for the current year.'),
      '#default_value' => $this->configuration['copyright'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['copyright'] = $form_state->getValue('copyright');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $markup = "";
    if ($text = $this->configuration['copyright']) {
      $text = str_replace('[year]', date("Y"), $this->t($text));
      $markup .= $text;
    }
    if (empty($markup)) {
      return;
    }
    return [
      'content' => [
        '#markup' => $markup,
      ],
    ];
  }

}
