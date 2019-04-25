<?php

/*
 *
 * Model class. Abstraction of the data stored on the database.
 *
 */

class Model {
  private $pdo;

  function __construct($pdo) {
    $this->pdo = $pdo;
  }

  function read_template_languages(){
    $sta = $this->pdo->prepare("SELECT DISTINCT `lang` FROM `templates`");
    $sta->execute();
    $result = $sta->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  function read_categories(){
    $sta = $this->pdo->prepare("SELECT `id`,`cat` AS name FROM `categories`");
    $sta->execute();
    $result = $sta->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Select questions
  function read_questions($cat, $lang){
    $sta = $this->pdo->prepare("SELECT i.`id`, t.`fixed`, t.`list`, t.`many`, i.`contents` FROM `items` i INNER JOIN `templates` t ON t.`id` = i.`template_id` INNER JOIN `categories` c ON i.`cat_id` = c.`id` WHERE c.`cat` = :cat AND i.`enabled` = 1 AND t.`lang` = :lang");
    $sta->execute(array(':cat' => $cat, ':lang' => $lang));
    $questions_ans = $sta->fetchAll(PDO::FETCH_ASSOC);
    // Strip off identification of correct answer
    $ids = array();
    $questions = array();
    foreach($questions_ans as $question_ans){
      $contents_ans = json_decode($question_ans["contents"], true);
      $answer = array();
      if ($question_ans["list"] != 0){
        foreach($contents_ans["answer"] as $answer_ans){
          array_push($answer, $answer_ans[1]);
        }
        shuffle($answer);
      }
      array_push($questions, array(
        "id" => $question_ans["id"],
        "fixed" => $question_ans["fixed"],
        "list" => $question_ans["list"],
        "many" => $question_ans["many"],
        "contents" => json_encode(array(
          "context" => $contents_ans["context"],
          "answer" => $answer
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
      ));
      array_push($ids, $question_ans["id"]);
    }
    return array("questions" => $questions, "ids" => $ids);
  }

  // Get the correct answer for a question
  function read_correct_answer($id){
    $sta = $this->pdo->prepare("SELECT i.`id` AS item_id, t.`fixed`, t.`list`, t.`many`, i.`contents` FROM `items` i INNER JOIN `templates` t ON t.`id` = i.`template_id` WHERE i.`id` = :item_id AND i.`enabled` = 1");
    $sta->execute(array(':item_id' => $id));
    $item = $sta->fetch(PDO::FETCH_ASSOC);
    $contents = json_decode($item["contents"], true);
    if ($item["list"] > 0 && $item["many"] == 1){
      // Checkbox
      $correct_answer = array();
      foreach($contents["answer"] as $answer){
        if ( $answer[0] == 1 ) array_push($correct_answer, $answer[1]);
      }
      return array("list" => $item["list"], "many" => $item["many"], "answer" => $correct_answer);
    }
    if ($item["list"] > 0 && $item["many"] == 0){
      // Radio
      foreach($contents["answer"] as $answer){
        if ( $answer[0] == 1 ){
          return array("list" => $item["list"], "many" => $item["many"], "answer" => $answer[1]);
        }
      }
    }
    // Written
    return array("list" => $item["list"], "many" => $item["many"], "answer" => $contents["answer"]);
  }

}
?>
