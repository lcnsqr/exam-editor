<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $data['txt']['title']; ?></title>
<link rel="stylesheet" href="<?php echo $data['client_uri']; ?>/fonts.css">
<link rel="stylesheet" href="<?php echo $data['client_uri']; ?>/editor.css">
</head>
<body>

<div id="top">
<h2><?php echo $data['txt']['item_count_per_category']; ?></h2>
<ul id="item_count">
<?php foreach ( $data['items_per_cat'] as $cat ): ?>
<li><?php echo $cat["name"]; ?>: <strong><?php echo $cat["count"]; ?></strong></li>
<?php endforeach; ?>
</ul>
</div><!-- #top -->

<?php foreach ( $data['templates'] as $template ): ?>
<div class="editor" data-template-id="<?php echo $template['template_id']; ?>" data-template-item-count="<?php echo $template['template_item_count']; ?>" data-lang="<?php echo $template['lang']; ?>" data-list="<?php echo $template['list']; ?>" data-many="<?php echo $template['many']; ?>" data-item-id="<?php echo $template['item_id']; ?>" data-item-cat-id="<?php echo $template['item_cat_id']; ?>" data-item-cat="<?php echo $template['item_cat']; ?>" data-item-enabled="<?php echo $template['item_enabled']; ?>">

<div class="header">
<h2><?php echo $template['descr']; ?></h2>
<div class="tools">
<ul>
<li><?php echo $data['txt']['category_item_count']; ?> <span class="template_item_count"><?php echo $template['template_item_count']; ?></span></li>
<li><a href="#<?php echo $template['template_id']; ?>" data-template-id="<?php echo $template['template_id']; ?>" class="toggle_editor" data-visible="1"><img src="<?php echo $data['client_uri']; ?>/images/arrow_left.svg" alt="Toggle" /></a></li>
</ul>
</div><!-- .tools -->
</div><!-- .header -->

<div class="body" data-visible="1" data-template-id="<?php echo $template['template_id']; ?>">

<div class="info">
<script type="text/json" data-id="template_items"><?php echo $data['template_items'][$template['template_id']]; ?></script>
<fieldset class="nav">
<legend><?php echo $data['txt']['item_browser']; ?></legend>
<ul class="item_nav">
<li><?php echo $data['txt']['item_browser_item']; ?> <span class="item_pos"><?php echo $template['template_item_count']; ?></span> <?php echo $data['txt']['item_browser_of']; ?> <span class="template_item_count"><?php echo $template['template_item_count']; ?></span></li>
<li><a href="#prev" data-action="index.php?label=item" data-key="" data-template-id="<?php echo $template['template_id']; ?>" class="item_nav_prev"><img src="<?php echo $data['client_uri']; ?>/images/arrow_left.svg" alt="<?php echo $data['txt']['previous']; ?>" /></a></li>
<li><a href="#next" data-action="index.php?label=item" data-key="" data-template-id="<?php echo $template['template_id']; ?>" class="item_nav_next"><img src="<?php echo $data['client_uri']; ?>/images/arrow_left.svg" alt="<?php echo $data['txt']['next']; ?>" /></a></li>
</ul><!-- .item_nav -->
</fieldset><!-- .nav -->
<div class="fixed">
<?php echo $template['fixed']; ?>
</div><!-- .fixed -->
<ul class="sample_answer">
</ul><!-- .sample_answer -->
<script type="text/json" data-id="item_contents"><?php echo $template['contents']; ?></script>
<p><?php echo $data['txt']['item_id']; ?> <strong>#<span data-id="item_id"></span></strong></p>
<p><?php echo $data['txt']['item_category']; ?> <strong><span data-id="item_cat" data-item-cat-id=""></span></strong></p>
<p><?php echo $data['txt']['item_enabled']; ?> <strong><span data-id="item_enabled" data-item-enabled=""></span></strong></p>
</div><!-- .info -->

<div class="form_edit">
<form action="index.php?label=item_new">
<fieldset class="context">
<legend><?php echo $data['txt']['legend_context']; ?></legend>
</fieldset>
<fieldset class="answer">
<legend><?php echo $data['txt']['legend_answers']; ?></legend>
<?php if ( $template['list'] > 0 ): ?>
<!-- Multiple choice -->
<ul>
<?php for($i = 0; $i < $template['list']; $i++): ?>
<li class="input_placing">
<?php if ( $template['many'] == 0 ): ?>
<!-- Only one correct answer -->
<input type="radio" name="correct" value="<?php echo $i; ?>" data-answer="<?php echo $i; ?>">
<?php else: ?>
<!-- More than correct answer -->
<input type="checkbox" name="correct" value="<?php echo $i; ?>" data-answer="<?php echo $i; ?>">
<?php endif; ?>
<textarea lang="<?php echo $template['lang']; ?>" name="answer_<?php echo $i; ?>" data-answer="<?php echo $i; ?>"></textarea>
</li>
<?php endfor; ?>
</ul>
<?php else: ?>
<!-- Written answer -->
<div class="written_answer"></div>
<p><input type="button" name="btnAddWritten" value="&#x2795;"></p>
<?php endif; ?>
</fieldset>
<div class="fieldset_placing">
<fieldset class="cat">
<legend><?php echo $data['txt']['legend_category']; ?></legend>
<p class="input_placing">
<select name="cat">
<?php foreach ($data['categories'] as $cat): ?>
<option value="<?php echo $cat['id']; ?>"><?php echo $cat['cat']; ?></option> 
<?php endforeach; ?>
</select>
</p>
</fieldset>
<fieldset class="enabled">
<legend><?php echo $data['txt']['legend_availability']; ?></legend>
<p class="input_placing">
<input type="checkbox" name="enabled" checked data-item-id="<?php echo $template['item_id']; ?>" id="enabled_<?php echo $template['item_id']; ?>">
<label for="enabled_<?php echo $template['item_id']; ?>"><?php echo $data['txt']['check_item_enabled']; ?></label>
</p>
</fieldset>
<fieldset class="overwrite">
<legend><?php echo $data['txt']['legend_replacement']; ?></legend>
<p class="input_placing">
<input type="checkbox" name="overwrite" data-item-id="<?php echo $template['item_id']; ?>" id="overwrite_<?php echo $template['item_id']; ?>" data-label="<?php echo $data['txt']['item_overwrite']; ?>">
<label for="overwrite_<?php echo $template['item_id']; ?>"><?php echo $data['txt']['item_overwrite']; ?><span data-id="item_id"><?php echo $template['item_id']; ?></span></label>
</p>
</fieldset>
</div><!-- .fieldset_placing -->
<p><input type="button" name="btnCopy" value="<?php echo $data['txt']['button_copy']; ?>"><input type="reset" name="btnClean" value="<?php echo $data['txt']['button_clean']; ?>"><input type="submit" name="btnSave" value="<?php echo $data['txt']['button_save']; ?>"></p>
</form>
</div><!-- .form_edit -->

</div><!-- .body -->
</div><!-- .editor -->
<?php endforeach; ?>

<template id="template_var">
<p class="input_placing"><textarea name="var"></textarea></p>
</template>

<script src="<?php echo $data['client_uri']; ?>/index.js"></script>
</body>
</html>
