<?php 

/*
 *
 * Controller file. Handles all requests from the client.
 *
 */

// Load configuration
include 'config.php';

// Localized texts
include 'lang.php';

// Database access
$pdo = new PDO("mysql:host=".$CONFIG['db_host'].";dbname=".$CONFIG['db_name'], $CONFIG['db_user'], $CONFIG['db_pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
include 'model.php';
$model = new Model($pdo);

// Output rendering class
include 'output.php';
$output = new Output($CONFIG['client_dir']);

// Action to execute
switch (strtolower($_SERVER['REQUEST_METHOD'])){

  case 'get':
    $output->template("editor.php", array(
      'txt' => $LANG[$CONFIG['lang']],
      'items_per_cat' => $model->count_items_per_cat($CONFIG['lang']),
      'templates' => $model->read_templates($CONFIG['lang']),
      'categories' => $model->read_categories(),
      'template_items' => $model->read_template_items(0, $CONFIG['lang'])
    ));
  break;

  case 'post':
    $contents = file_get_contents("php://input");
    switch ($_GET['label']){

      case 'item_new':
        $item = json_decode($contents, true);
        if ( intval($item['overwrite']) > 0 ){
          // Overwrite item
          $item_id = intval($item['overwrite']);
          $model->overwrite_item($item_id, $item['template_id'], $item['contents'], $item['cat_id'], $item['enabled']);
        }
        else {
          // Insert item
          $item_id = $model->write_item($item['template_id'], $item['contents'], $item['cat_id'], $item['enabled']);
        }
        // Send back saved item and id list of items associated to the related template
        $output->sendJSON(array(
          'items_per_cat' => $model->count_items_per_cat($CONFIG['lang']),
          'item' => $model->read_item($item_id),
          'template_items' => $model->read_template_items($item['template_id'], $CONFIG['lang'])
        ));
      break;

      case 'item':
        $item = json_decode($contents, true);
        // Send back saved item and id list of items associated to the related template
        $output->sendJSON(array(
          'items_per_cat' => $model->count_items_per_cat($CONFIG['lang']),
          'item' => $model->read_item($item['item_id']),
          'template_items' => $model->read_template_items($item['template_id'], $CONFIG['lang'])
        ));
      break;

    }
  break;

}

?>
