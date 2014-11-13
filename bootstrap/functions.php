<?php

function p() {

    $numargs = func_num_args();
    foreach (func_get_args() as $value) {
      echo "<pre>"; var_dump($value); echo "</pre>";
    }

}

function pp() {

  $args = func_get_args();
  p($args);
  die();

}