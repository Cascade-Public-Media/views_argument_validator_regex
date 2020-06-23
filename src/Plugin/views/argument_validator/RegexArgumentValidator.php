<?php

namespace Drupal\views_argument_validator_regex\Plugin\views\argument_validator;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\argument_validator\ArgumentValidatorPluginBase;

/**
 * Validate whether an argument matches a provided regex pattern.
 *
 * @ingroup views_argument_validate_plugins
 *
 * @ViewsArgumentValidator(
 *   id = "regex",
 *   title = @Translation("Regular expression (regex)")
 * )
 */
class RegexArgumentValidator extends ArgumentValidatorPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['pattern'] = ['default' => ''];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    $form['pattern'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Regular expression'),
      '#description' => $this->t('Regex pattern to use for validating the
        argument.'),
      '#default_value' => $this->options['pattern'],
      '#states' => [
        'required' => [
          ':input[name="options[specify_validation]"]' => ['checked' => TRUE],
          ':input[name="options[validate][type]"]' => ['value' => 'regex'],
        ],
      ],
    ];

    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateOptionsForm(&$form, FormStateInterface $form_state) {
    $form_path = ['options', 'validate', 'options', 'regex', 'pattern'];
    $pattern = $form_state->getValue($form_path);

    // Ensure that the pattern is valid by testing it against a NULL value. This
    // will return "0" for a valid pattern and FALSE for an invalid one, so the
    // result (`$valid`) must be strict type checked. Pattern may be empty (e.g.
    // if the Regex validator is selected but validation is disabled).
    if (!empty($pattern)) {
      $valid = @preg_match($pattern, NULL);
      if ($valid === FALSE) {
        $form_state->setErrorByName(
          implode('][', $form_path),
          $this->t('Invalid regular expression pattern.')
        );
      }
    }

    parent::validateOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateArgument($arg) {
    return (bool) preg_match($this->options['pattern'], $arg);
  }

}
