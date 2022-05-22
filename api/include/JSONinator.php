<?php
/*
 * \param fields => array of strings
 * \param mysqli_result => object
 */
function createArray($fields, $mysqli_result) {
  /* Init the json var */
  $tmp = "[";

  $result_counter = 0;
  while ($row = mysqli_fetch_row($mysqli_result)) {
    $result_counter++;

    /* Creating an object */
    $tmp = $tmp . "{";

    /* Adding the elements */
    for ($i = 0; $i < count($fields); $i++) {
      $tmp = $tmp."\"".$fields[$i]."\":\"".$row[$i]."\"";
      if ($i < count($fields)-1)
        $tmp = $tmp.",";
    }

    /* Closing the object */
    $tmp = $tmp . "}";

    /* Checking if there is another object to be added */
    if ($result_counter < mysqli_num_rows($mysqli_result))
      $tmp = $tmp . ",";
  }

  /* Closing the array */
  $tmp = $tmp . "]";

  return $tmp;
}

function createObject($fields, array $array_content) {
  $tmp = "{";
  for ($i=0; $i < count($fields); $i++) {
    $tmp = $tmp . "\"" . $fields[$i] . "\":" . $array_content[$i];
    if ($i < count($fields)-1)
      $tmp = $tmp . ",";
  }

  $tmp = $tmp . "}";

  return $tmp;
}

function assocToJSON(array $fields, array $result) {
  $tmp = "{";

  for ($i=0; $i < count($fields); $i++) {
    $tmp = $tmp . "\"" . $fields[$i] . "\":";
    $tmp = $tmp . "\"" . $result[$fields[$i]] . "\"";

    /* Checking if the ',' should go */
    if ($i < count($fields)-1)
      $tmp = $tmp . ",";
  }

  $tmp = $tmp . "}";
  return $tmp;
}

function createNestedJSON(array $fields, array $result) {
  $tmp = "{";

  for ($i=0; $i < count($fields); $i++) {
    $tmp = $tmp . "\"" . $fields[$i] . "\":";
    $tmp = $tmp . $result[$i];

    /* Checking if the ',' should go */
    if ($i < count($fields)-1)
      $tmp = $tmp . ",";
  }

  $tmp = $tmp . "}";
  return $tmp;
}
?>
