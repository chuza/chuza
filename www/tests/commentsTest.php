<?php

error_reporting(E_ALL^E_NOTICE);


class testComments extends PHPUnit_Framework_TestCase {

  public function setUp() {
    global $db;
    include('../config.php');
    $db = $this->getMock('RGDB');
  }

  public function tearDown() {
    global $db;
    $db = NULL;
  }

  public function testGetDomainFromImage() {

    $values = Array(
      Array ('http://i.imgur.com/xyzu.png','i.imgur.com'),
      Array ('http://imgur.com/xyzu.png','imgur.com'),
      Array ('http://www.imgur.es/xyzu.png','www.imgur.es'),
      Array ('http://fully.known.imgur.es',''),
      Array ('http://imgur.es/hyz.gif','imgur.es'),
      Array ('http://imgur.jpg',false),
      Array ('http://www.imgur.',false)
    );

    foreach ($values as $val) { 
      $v = getDomainFromImage($val[0]);
      $this->assertEquals($v,$val[1]);
      var_dump($v);
    }

  }
}
