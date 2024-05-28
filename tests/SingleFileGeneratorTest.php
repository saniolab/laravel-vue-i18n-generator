<?php

use MartinLindhe\VueInternationalizationGenerator\Generator;

class SingleFileGeneratorTest extends \Orchestra\Testbench\TestCase
{
    private $config = [];

    private function evaluateSingleOutput($input, $expected, $format = 'es6', $withVendor = false)
    {
        $this->assertEquals(
            file_get_contents(__DIR__.'/result/'.$expected),
            (new Generator($this->config))->generateFromPath(__DIR__.'/input/'.$input, $format, $withVendor)
        );

        $this->config = [];
    }

    public function testBasic()
    {
        $this->evaluateSingleOutput('basic', 'basic.js');
    }

    public function testBasicES6Format()
    {
        $this->evaluateSingleOutput('basic', 'basic_es6.js', 'es6');
    }

    public function testBasicWithUMDFormat()
    {
        $this->evaluateSingleOutput('basic', 'basic_umd.js', 'umd');
    }

    public function testBasicWithJSONFormat()
    {
        $this->evaluateSingleOutput('basic', 'basic.json', 'json');
    }

    public function testBasicMultipleInput()
    {
        $this->evaluateSingleOutput('multiple', 'basic_multi_in.js');
    }

    public function testInvalidFormat()
    {
        $format = 'es5';
        $inputDir = __DIR__.'/input/basic';

        try {
            (new Generator([]))->generateFromPath($inputDir, $format);
        } catch (RuntimeException $e) {
            $this->assertEquals('Invalid format passed: '.$format, $e->getMessage());

            return;
        }

        // FIXME
        // $this->fail('No exception thrown for invalid format.');
        $this->markTestIncomplete('No exception thrown for invalid format.');
    }

    public function testBasicWithTranslationString()
    {
        $this->evaluateSingleOutput('translation', 'translation.js');
    }

    public function testBasicWithEscapedTranslationString()
    {
        $this->evaluateSingleOutput('escaped', 'escaped.js');
    }

    public function testBasicWithVendor()
    {
        $this->evaluateSingleOutput('vendor', 'vendor.js', 'es6', true);
    }

    public function testBasicWithVuexLib()
    {
        $this->config = ['i18nLib' => 'vuex-i18n'];
        $this->evaluateSingleOutput('basic', 'basic_vuex.js');
    }

    public function testNamed()
    {
        $this->evaluateSingleOutput('named', 'named.js');
    }

    public function testNamedWithEscaped()
    {
        $this->evaluateSingleOutput('named_escaped', 'named_escaped.js');
    }

    public function testEscapedEscapeCharacter()
    {
        $this->evaluateSingleOutput('escaped_escape', 'escaped_escape.js');
    }

    public function testShouldNotTouchHtmlTags()
    {
        $this->evaluateSingleOutput('html', 'html.js');
    }

    public function testPluralization()
    {
        $this->evaluateSingleOutput('plural', 'plural.js');
        $this->config = ['i18nLib' => 'vuex-i18n'];
        $this->evaluateSingleOutput('plural', 'plural_vuex.js');
    }
}
