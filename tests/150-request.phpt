--TEST--
Services_Digg_Request
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Digg/Request.php';

$endPoints = array(
    'popular' => Services_Digg_Request::buildCall('/stories/popular'),
    'errors'  => Services_Digg_Request::buildCall('/errors'),
    'topics'  => Services_Digg_Request::buildCall('/topics'),
    'nyt'     => Services_Digg_Request::buildCall('/stories/popular', array(
        'domain' => 'nytimes.com'
    ))
);

$req = new Services_Digg_Request($endPoints);


// Bunch of other stuff here

if (!$req->popular instanceof Services_Digg_Exception) {
    foreach ($req->popular as $story) {
        var_dump(is_numeric($story->id));
    }
} else {
    echo $req->popular->getMessage() . "\n";
    echo $req->popular->getCall() . "\n";
    echo $req->popular->getResponse() . "\n";
}

if (!$req->errors instanceof Services_Digg_Exception) {
    foreach ($req->errors->errors as $error) {
        if ($error->code == 404) {
            echo $error->message . "\n";
        }
    }
} else {
    echo $req->errors->getMessage() . "\n";
    echo $req->errors->getCall() . "\n";
    echo $req->errors->getResponse() . "\n";
}

if (!$req->topics instanceof Services_Digg_Exception) {
    foreach ($req->topics as $topic) {
        if ($topic->name == 'Apple') {
            echo $topic->short_name . "\n";
            echo $topic->container->short_name . "\n";
        }
    }
} else {
    echo $req->topics->getMessage() . "\n";
    echo $req->topics->getCall() . "\n";
    echo $req->topics->getResponse() . "\n";
}

if (!$req->nyt instanceof Services_Digg_Exception) {
    foreach ($req->nyt as $story) {
        var_dump((strpos($story->link, 'nytimes.com') !== false));   
    }
} else {
    echo $req->nyt->getMessage() . "\n";
    echo $req->nyt->getCall() . "\n";
    echo $req->nyt->getResponse() . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
Not found
apple
technology
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
