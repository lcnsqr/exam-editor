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
    $sta = $this->pdo->prepare("SELECT `id`,`cat` FROM `categories`");
    $sta->execute();
    $result = $sta->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  function count_items_per_cat($lang){
    $sta = $this->pdo->prepare("SELECT c.`cat` AS name, s.`count` FROM (SELECT COUNT(i.`id`) AS count, i.`cat_id` FROM `items` i INNER JOIN `templates` t ON t.`id` = i.`template_id` WHERE t.`lang` = :lang GROUP BY i.`cat_id`) s INNER JOIN `categories` c ON c.`id` = s.`cat_id`");
    $sta->execute(array("lang" => $lang));
    $result = $sta->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Template details and last associated item
  function read_templates($lang){
    $sta = $this->pdo->prepare("SELECT t.`id` AS template_id,t.`lang`,t.`descr`,t.`fixed`,t.`list`,t.`many`,s.`template_item_count`,s.`item_id`,i.`contents`,i.`enabled` AS item_enabled,c.`id` AS item_cat_id,c.`cat` AS item_cat FROM (SELECT COUNT(i.`id`) AS template_item_count, MAX(i.`id`) AS item_id, i.`template_id` FROM `items` i GROUP BY i.`template_id`) s INNER JOIN `templates` t ON t.`id` = s.`template_id` INNER JOIN `items` i ON i.`id` = s.`item_id` INNER JOIN `categories` c ON c.`id` = i.`cat_id` WHERE t.`lang` = :lang");
    $sta->execute(array("lang" => $lang));
    $result = $sta->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // Save a new question
  function write_item($template_id, $contents, $cat_id, $enabled){
    $sta = $this->pdo->prepare("INSERT INTO items(`template_id`,`contents`,`cat_id`,`enabled`) VALUES(:template_id, :contents, :cat_id, :enabled)");
    $sta->execute(array(
      "template_id" => $template_id,
      "contents" => $contents,
      "cat_id" => $cat_id,
      "enabled" => $enabled
    ));
    return $this->pdo->lastInsertId();
  }

  // Update a existing question
  function overwrite_item($item_id, $template_id, $contents, $cat_id, $enabled){
    $sta = $this->pdo->prepare("UPDATE items SET `template_id` = :template_id, `contents` = :contents, `cat_id` = :cat_id, `enabled` = :enabled WHERE `id` = :item_id");
    $sta->execute(array(
      "template_id" => $template_id,
      "contents" => $contents,
      "cat_id" => $cat_id,
      "enabled" => $enabled,
      "item_id" => $item_id
    ));
  }

  // Load a question
  function read_item($item_id){
    $sta = $this->pdo->prepare("SELECT i.`id` AS item_id,i.`contents`,i.`enabled`,i.`cat_id` AS item_cat_id,c.`cat` AS item_cat FROM `items` i INNER JOIN `categories` c ON c.`id` = i.`cat_id` WHERE i.`id` = :item_id");
    $sta->execute(array(':item_id' => $item_id));
    $result = $sta->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // List of item IDs associated to a template.
  // If $template_id = 0, returns a list of template IDs and IDs of associated items.
  function read_template_items($template_id, $lang){
    if ($template_id == 0){
      $sta1 = $this->pdo->prepare("SELECT t.`id` AS template_id FROM `templates` t WHERE t.`lang` = :lang");
      $sta1->execute(array("lang" => $lang));
      $templates = $sta1->fetchAll(PDO::FETCH_ASSOC);
      $result = array();
      foreach ($templates as $template){
        $sta2 = $this->pdo->prepare("SELECT i.`id` AS item_id FROM `items` i WHERE i.`template_id` = :template_id");
        $sta2->execute(array(':template_id' => $template['template_id']));
        $result = $result + array($template['template_id'] => json_encode(array_map(function($item){return (int)$item['item_id'];}, $sta2->fetchAll(PDO::FETCH_ASSOC))));
      }
      return $result;
    }
    else {
      $sta = $this->pdo->prepare("SELECT i.`id` AS item_id FROM `items` i WHERE i.`template_id` = :template_id");
      $sta->execute(array(':template_id' => $template_id));
      $result = $sta->fetchAll(PDO::FETCH_ASSOC);
      return json_encode(array_map(function($item){return (int)$item['item_id'];}, $result));
    }
  }

}
?>
