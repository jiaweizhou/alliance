<?php
/**
 * *************************************************************************
 *
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 *
 * ************************************************************************
 */
/**
 *
 * @file test_AssertHelper.php
 * @encoding UTF-8
 * 
 * 
 *         @date 2014年12月31日
 *        
 */

if (! defined('PUSH_SDK_HOME')) {
    define('PUSH_SDK_HOME', dirname(dirname(__FILE__)));
}

include_once PUSH_SDK_HOME . '/lib/AssertHelper.php';

class AssertHelperTest extends PHPUnit_Framework_TestCase {
    /**
     * @return AssertHelper
     */
    public function testCreateAssert() {
        return new AssertHelper();
    }
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testType($ah) {
        echo 'check test Type!!!';
        $this -> assertTrue($ah -> type(101, 'int'));
        $this -> assertTrue($ah -> type(11, 'integer'));
        $this -> assertTrue($ah -> type(2.123, 'number'));
        $this -> assertTrue($ah -> type('abc', 'string'));
        $this -> assertTrue($ah -> type(true, 'bool'));
        $this -> assertTrue($ah -> type(false, 'boolean'));
        $this -> assertTrue($ah -> type(array (
            1,
            2,
            3,
        ), 'array'));
        $this -> assertTrue($ah -> type(array (
            'a' => 100,
            'b' => 200,
        ), 'array'));
        $this -> assertTrue($ah -> type($ah, 'object'));
        $this -> assertTrue($ah -> type(null, 'null'));
        
        $this -> assertTrue($ah -> type('abc', array (
            'string',
            'array',
        )));
        $this -> assertTrue($ah -> type(array (
            1,
            2,
            3,
        ), array (
            'string',
            'array',
        )));
        $this -> assertFalse($ah -> type(array (
            1,
            2,
            3,
        ), array (
            'string',
            'number',
        )));
        $this -> assertFalse($ah -> type(array (
            1,
            2,
            3,
        ), 'number'));
    }
    
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testMoreThat($ah) {
        $this -> assertTrue($ah -> moreThat(101, 100));
        $this -> assertFalse($ah -> moreThat(99, 100));
    }
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testLessThat($ah) {
        $this -> assertTrue($ah -> lessThat(99, 100));
        $this -> assertFalse($ah -> lessThat(101, 100));
    }
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testBetween($ah) {
        $this -> assertTrue($ah -> between(100, 0, 200));
        $this -> assertFalse($ah -> between(101, 0, 100));
        $this -> assertTrue($ah -> between(0, 0, 100));
        $this -> assertTrue($ah -> between(100, 0, 100));
    }
    
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testMatch($ah) {
        $this -> assertTrue($ah -> match(100, '/\d{3}/'));
        $this -> assertFalse($ah -> match('abc', '/\d{3}/'));
    }
    
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testEqual($ah) {
        $this -> assertFalse($ah -> equal('100', 'abc'));
        $this -> assertTrue($ah -> equal('100', 100));
    }
    
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testEqualStrict($ah) {
        $this -> assertFalse($ah -> equalStrict('100', 'abc'));
        $this -> assertFalse($ah -> equalStrict('100', 100));
        $this -> assertTrue($ah -> equalStrict('100', '100'));
    }
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testMaybe($ah) {
        $this -> assertFalse($ah -> maybe('100', 'abc'));
        $this -> assertFalse($ah -> maybe('100', array (
            'a',
            'b',
            'c',
        )));
        $this -> assertFalse($ah -> maybe(100, array (
            '100',
            '200',
            '300',
        )));
        $this -> assertTrue($ah -> maybe('100', array (
            '100',
            '200',
            '300',
        )));
        $this -> assertTrue($ah -> maybe('a', array (
            'a',
            'b',
            'c',
        )));
    }
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testNot($ah) {
        $this -> assertTrue($ah -> not('100', '100'));
        $this -> assertFalse($ah -> not(true));
        $this -> assertFalse($ah -> not(1));
        $this -> assertTrue($ah -> not(false));
        $this -> assertTrue($ah -> not(0));
        $this -> assertFalse($ah -> not('100', array (
            '100',
            '200',
            '300',
        )));
        $this -> assertTrue($ah -> not('123', array (
            '100',
            '200',
            '300',
        )));
        $this -> assertFalse($ah -> not('a', array (
            'a',
            'b',
            'c',
        )));
    }
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testPossible($ah) {
        
        $condition1 = array (
            'lessThat' => array (
                50,
            ),
            'moreThat' => array (
                150,
            ),
            "maybe" => array (
                60,
                70,
                80,
                90,
            ),
        );
        
        $this -> assertTrue($ah -> possible(100, '100'));
        $this -> assertTrue($ah -> possible(100, array (
            100,
            200,
            300,
            400,
        )));
        $this -> assertFalse($ah -> possible(91, $condition1));
        $this -> assertTrue($ah -> possible(90, $condition1));
        
        // 10 < value < 20 || 50 < vlaue < 60 || vlaue == unlimit
        $this -> assertFalse($ah -> possible(90, array (
            'between' => array (
                10,
                20,
            ),
        ), array (
            'between' => array (
                50,
                60,
            ),
        ), array (
            'match' => '/unlimit/i',
        )));
        
        // vlaue == unlimit || 10 < value < 20 || 50 < vlaue < 60
        $this -> assertTrue($ah -> possible('unlimit', array (
            'match' => 'unlimit',
            'between' => array (
                10,
                20,
            ),
        ), array (
            'between' => array (
                50,
                60,
            ),
        )));
        
        $arr = array (
            'type' => 'array',
            'match' => '/\d{10,25}/', 
        );
        
        $this -> assertTrue($ah -> possible('123345456678879', $arr));
        
    }
    
    /**
     * @depends testCreateAssert
     * 
     * @param AssertHelper $ah        
     */
    public function testMakesure($ah) {
        $this -> assertTrue($ah -> makesure('100', '100'));
        $this -> assertTrue($ah -> makesure(true));
        $this -> assertTrue($ah -> makesure(1));
        $this -> assertFalse($ah -> makesure(false));
        $this -> assertFalse($ah -> makesure(0));
        
        // this is impossibility be true;
        $this -> assertFalse($ah -> makesure('100', array (
            '100',
            '200',
            '300',
        )));
        $this -> assertFalse($ah -> makesure('a', array (
            'a',
            'b',
            'c',
        )));
        
        $this -> assertFalse($ah -> makesure(array (
            '100',
            '200',
            '300',
        ), array (
            'type' => 'number',
        )));
        
        // complex
        $this -> assertTrue($ah -> makesure(100, array (
            'between' => array (
                50,
                150,
            ),
            'lessThat' => 150,
            'moreThat' => 80,
            'maybe' => array (
                90,
                100,
                110,
            ),
        )));
        
        $this -> assertFalse($ah -> makesure(100, array (
            'between' => array (
                50,
                150,
            ),
            'lessThat' => 150,
            'moreThat' => 80,
            'maybe' => array (
                90,
                110,
            ),
        )));
        
        $this -> assertFalse($ah -> makesure(100, array (
            'between' => array (
                101,
                150,
            ),
            'lessThat' => 150,
            'moreThat' => 80,
            'maybe' => array (
                90,
                100,
                110,
            ),
        )));
        
        $this -> assertFalse($ah -> makesure('100', array (
            'match' => '/\d{3}/',
            'not' => array (
                '100',
                '200',
                '300',
            ),
        )));
        
        $this -> assertTrue($ah -> makesure('123', array (
            'match' => '/\d{3}/',
            'not' => array (
                '100',
                '200',
                '300',
            ),
        )));
        
        $this -> assertTrue($ah -> makesure(array("9044331805861663059", "8669180648405502819", "3333449854796766867", "5861757435658053859",), array (
            'type' => array (
                    'array', 
                    'string' 
                )
        )));
    }
}