<?php

use Pawelzny\Support;
use PHPUnit\Framework\TestCase;

class NormalizeTest extends TestCase
{
    public function testToSnakeCase()
    {
        $test_cases = [
            'simpleTest' => 'simple_test',
            'easy' => 'easy',
            'HTML' => 'html',
            'simpleXML' => 'simple_xml',
            'PDFLoad' => 'pdf_load',
            'startMIDDLELast' => 'start_middle_last',
            'AString' => 'a_string',
            'Some4Numbers234' => 'some4_numbers234',
            'TEST123String' => 'test123_string',
            'hello_world' => 'hello_world',
            'multiple__underscores' => 'multiple__underscores',
            '_underscoreFirstAndLast_' => '_underscore_first_and_last_',
            'hello_World' => 'hello_world',
            'HelloWorld' => 'hello_world',
            'helloWorldFoo' => 'hello_world_foo',
            'hello-world' => 'hello-world',
            'myHTMLFiLe' => 'my_html_fi_le',
            'aBaBaB' => 'a_ba_ba_b',
            'BaBaBa' => 'ba_ba_ba',
            'libC' => 'lib_c',
            '01234digitsFirst' => '01234digits_first',
            '56789DigitsFirst' => '56789_digits_first',
        ];

        foreach ($test_cases as $case => $expected) {
            $this->assertEquals($expected, Support\toSnakeCase($case));
        }
    }
}
