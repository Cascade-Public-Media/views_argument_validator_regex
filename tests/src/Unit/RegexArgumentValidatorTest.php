<?php

namespace Drupal\Tests\views_argument_validator_regex\Unit;

use Drupal\views_argument_validator_regex\Plugin\views\argument_validator\RegexArgumentValidator;
use Drupal\Tests\UnitTestCase;

/**
 * RegexArgumentValidatorTest units tests.
 *
 * @coversDefaultClass \Drupal\views_argument_validator_regex\Plugin\views\argument_validator\RegexArgumentValidator
 * @group views_argument_validator_regex
 */
class RegexArgumentValidatorTest extends UnitTestCase {

  /**
   * The view executable.
   *
   * @var \Drupal\views\ViewExecutable
   */
  protected $executable;

  /**
   * The view display.
   *
   * @var \Drupal\views\Plugin\views\display\DisplayPluginBase
   */
  protected $display;

  /**
   * The tested argument validator.
   *
   * @var \Drupal\views\Plugin\views\argument_validator\Entity
   */
  protected $argumentValidator;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->executable = $this->getMockBuilder('Drupal\views\ViewExecutable')
      ->disableOriginalConstructor()
      ->getMock();
    $this->display = $this->getMockBuilder('Drupal\views\Plugin\views\display\DisplayPluginBase')
      ->disableOriginalConstructor()
      ->getMock();
    $this->argumentValidator = new RegexArgumentValidator([], 'regex_test', []);
  }

  /**
   * @covers ::validateArgument
   *
   * @param array $settings
   *   Regex validator settings.
   *
   * @param mixed $argument
   *   Argument to test.
   *
   * @param mixed $expected
   *   Expected result.
   *
   * @dataProvider argumentDataProvider
   */
  public function testValidateArgument(array $settings, $argument, $expected) {
    $default_options = [];
    $default_options['access'] = TRUE;
    $default_options['bundles'] = [];
    $default_options['operation'] = 'test_op';
    $options = array_merge($default_options, $settings);
    $this->argumentValidator->init($this->executable, $this->display, $options);

    $this->assertEquals(
      $this->argumentValidator->validateArgument($argument),
      $expected
    );
  }

  /**
   * Data provider for testValidateArgument().
   *
   * @return array
   *   Nested arrays of values to check:
   *   - $settings
   *   - $argument
   *   - $expected
   *
   * @see RangeArgumentValidatorTest::testValidateArgument()
   */
  public function argumentDataProvider() {
    $four_digits = "/^\d{4}$/";
    $date_ymd = "/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/";
    $alpha_ci = "/^[a-z]+$/i";
    return [
      [['pattern' => $four_digits], '1234', TRUE],
      [['pattern' => $four_digits], '123', FALSE],
      [['pattern' => $four_digits], 'abcd', FALSE],
      [['pattern' => $date_ymd], '2020-01-01', TRUE],
      [['pattern' => $date_ymd], date('Y-m-d'), TRUE],
      [['pattern' => $date_ymd], '0000-00-00', FALSE],
      [['pattern' => $alpha_ci], 'John', TRUE],
      [['pattern' => $alpha_ci], 'john', TRUE],
      [['pattern' => $alpha_ci], 'J0hn', FALSE],
    ];
  }

}
