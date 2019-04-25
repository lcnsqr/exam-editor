<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $data['txt']['title']; ?></title>
<link rel="stylesheet" href="<?php echo $data['client_uri']; ?>/fonts.css">
<link rel="stylesheet" href="<?php echo $data['client_uri']; ?>/exam.css">
</head>
<body>

<div id="menu">
<ul class="categories">
<?php foreach ( $data["categories"] as $cat ): ?>
<li><a href="#<?php echo $cat["name"]; ?>"><?php echo $data['txt']['label_topic']; ?> <?php echo $cat["name"]; ?></a></li>
<?php endforeach; ?>
</ul>
</div><!-- #menu -->

<div id="content">

<div id="top">
<h2><input type="button" id="menu-trigger" value="◀"><?php echo $data['txt']['header_title']; ?></h2>
<ul class="categories">
<?php foreach ( $data["categories"] as $cat ): ?>
<li><a href="#<?php echo $cat["name"]; ?>"><?php echo $data['txt']['label_topic']; ?> <?php echo $cat["name"]; ?></a></li>
<?php endforeach; ?>
</ul>
</div>

<div class="test_form" data-action="index.php?label=form"></div>

</div><!-- #content -->

<script src="<?php echo $data['client_uri']; ?>/exam.js"></script>
</body>
</html>
