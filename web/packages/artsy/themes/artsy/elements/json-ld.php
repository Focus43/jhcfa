<?php

function get_eventObject() {
//  global $post;
//  return $post;
}

$eventObject = get_eventObject();


  $payload["@context"] = "http://schema.org/";
    $payload["@type"] = "Event";
      $payload["name"] = $eventObject->getAttribute('presenting_organization')  //"name of the event"; // need to pull this from actual event
      $payload["startDate"] = "2016-05-14T21:30"; // need to pull this from actual event

      $payload["location"] = array(
        "@type" => "Place",
        "sameAs" => "http://jhcenterforthearts.org/",
        "name" => "The Center",
        "address" => "240 S. Glenwood St., Jackson, WY 83001",
      );
?>
