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
    switch ($_GET['label']){
      // Render exam form
      case "form" :
        $test = $model->read_questions($_GET['cat'], $CONFIG['lang']);
        $output->template("exam_form.php", array(
          'txt' => $LANG[$CONFIG['lang']],
          "cat" => $_GET["cat"],
          "questions" => $test["questions"],
          "ids" => $test["ids"]
        ));
      break;
      default:
        // List question categories
        $output->template("exam.php", array(
          'txt' => $LANG[$CONFIG['lang']],
          "categories" => $model->read_categories()
        ));
      break;
    }
  break;

  case 'post':
    $contents = file_get_contents("php://input");
    switch ($_GET['label']){

      case 'answers':
        // Evaluate answers
        $ids = json_decode($_POST["ids"]);
        $corr = array();
        foreach($ids as $id){
          // Evaluation defaults to incorrect
          $corr[$id] = 0;
          if ( ! array_key_exists($id, $_POST) ){
            // No answer = incorrect
            continue;
          }
          $ans = $_POST[$id];
          $correct = $model->read_correct_answer($id);
          if ( $correct["list"] > 0 && $correct["many"] == 1 ){
            // Checkbox
            if ( ! is_array($ans) || count($ans) != count($correct["answer"]) ){
              // Amount of choosen alternatives differs
              // from the amount of correct answers
              continue;
            }
            // Evaluate if all choosen alternatives are correct
            $correct = 1;
            for ($c = 0; $c < count($correct["answer"]); $c++){
              if ( ! in_array($correct["answer"][$c], $ans) ){
                // At least one correct alternative was not choosen
                $correct = 0;
                break;
              }
            }
            $corr[$id] = $correct;
            continue;
          }
          if ( $correct["list"] > 0 && $correct["many"] == 0 ){
            // Radio
            if ( $ans == $correct["answer"] ) $corr[$id] = 1;
            continue;
          }
          // Written
          if ( in_array($ans, $correct["answer"]) ) $corr[$id] = 1;
        }
        $output->sendJSON($corr);
      break;

    }
  break;

}

?>
