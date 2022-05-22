<?php
/*
 * -- api/human_garbage.php
 *
 * This page is for all the people refusing to accept me in their internet life
 */

/* Searching for GIPHY's library */
require_once __DIR__."/../vendor/autoload.php";

/* Creating objects and stuff (everythin copied by github's page) */
$api_instance = new GPH\Api\DefaultApi();
$api_key = "5RVqO9mCyNEbsB0JYcdb3enLqzIBc5pm";
$search_key = "shoo sparrow";
$rating = "g";
$fmt = "json";

try {
    $result = $api_instance->gifsRandomGet($api_key, $search_key, $rating, $fmt);
    echo $result;
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->gifsSearchGet: ', $e->getMessage(), PHP_EOL;
}
?>
