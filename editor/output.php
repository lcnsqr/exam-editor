<?php

/*
 *
 * Helper class to parse and send output to the client.
 *
 */

class Output {
  private $client;

  function __construct($client) {
    $this->client = $client;
  }

  function template($filename, $data){
    $data = $data + array('client_uri' => $this->client);
    ob_start();
    include $this->client . '/' . $filename;
    echo ob_get_clean();
  }

  function send($data){
    header('Content-Type: text/plain');
    echo $data;
  }

  function sendJSON($data){
    $json = json_encode($data);
    header('Content-Type: application/json');
    echo $json;
  }
}
?>
