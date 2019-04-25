<form name="test_form" method="post" action="index.php?label=answers">
<h3><?php echo $data['txt']['form_title']; ?> <?php echo $data["cat"]; ?></h3>
<script type="text/json" data-id="ids"><?php echo json_encode($data["ids"]); ?></script>

<?php foreach ( $data["questions"] as $number => $question ): ?>

<div class="question" data-id="<?php echo $question['id']; ?>" data-list="<?php echo $question['list']; ?>" data-many="<?php echo $question['many']; ?>">
<h4><?php echo $data['txt']['question']; ?> <?php echo $number + 1; ?></h4>
<div class="fixed">
<?php echo $question['fixed']; ?>
</div><!-- .fixed -->
<div class="answer" data-id="<?php echo $question['id']; ?>"></div>
<script type="text/json" data-id="item_contents"><?php echo $question['contents']; ?></script>
<p class="evaluate">
<input type="button" data-label="answer" value="<?php echo $data['txt']['evaluate']; ?>" data-id="<?php echo $question['id']; ?>">
</p>
</div><!-- .question -->

<?php endforeach; ?>

<p class="evaluate all">
  <input type="reset" value="<?php echo $data['txt']['reset_answers']; ?>">
  <input type="submit" value="<?php echo $data['txt']['avaluate_all']; ?>">
</p>
</form>
