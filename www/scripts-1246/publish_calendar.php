<?php

/* Google Calendar functions for use in scripts

// example

/*
createEvent($client, 'New Years Party',
    'Ring in the new year with Kim and I',
    'Our house', 
    '2006-12-31', '2007-01-01');
 */

// test

/*
$client = initCalendar();

$link = new Link;
$link->id = 19136;
$link->read();

echo '<pre>';
print_r($link);
createEvent($client, $link->title, $link->content, $link->start_date, $link->end_date);

*/


//error_reporting(E_ALL);

include_once('../config.php');
include_once(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');
include_once(mnminclude.'link.php');
require_once(mnminclude.'Zend/Loader.php');
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Calendar');


function initCalendar() {
  global $globals;

  // check configuration
  if (!$globals['gCalendar_user'] || !$globals['gCalendar_password'])
    return false; // not configured

  $gdataCal = new Zend_Gdata_Calendar();

  $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar

  $client = Zend_Gdata_ClientLogin::getHttpClient($globals['gCalendar_user'],
      $globals['gCalendar_password'], $service);

  return $client;
}


function createEvent ($client, $title = 'Tennis with Beth',
    $desc='Meet for a quick lesson', //$where = 'On the courts',
    $startDate = '2012-01-20', 
    $endDate = '2012-01-20')
{
  $gdataCal = new Zend_Gdata_Calendar($client);
  $newEvent = $gdataCal->newEventEntry();
  
  $newEvent->title = $gdataCal->newTitle($title);
  //$newEvent->where = array($gdataCal->newWhere($where));
  $newEvent->content = $gdataCal->newContent("$desc");
  
  $when = $gdataCal->newWhen();
  $when->startTime = "{$startDate}";
  $when->endTime = "{$endDate}";
  $newEvent->when = array($when);

  // Upload the event to the calendar server
  // A copy of the event as it is recorded on the server is returned
  $createdEvent = $gdataCal->insertEvent($newEvent);
  return $createdEvent->id->text;
}


