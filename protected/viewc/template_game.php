<!DOCTYPE html>
<html lang="en" dir="ltr" class="no-js">
<head>
	<?php include 'head.php'; ?>
</head>
<body class="<?php echo isset($data['body_class']) ? $data['body_class'] : '';?>">

<!-- Google TagManager -->
<?php include($sitePath . 'global/js/googleTagManager.js.php'); ?>

<?php /* WHAT IS THIS ????  -and WHY DO WE NEED IT ????
<noscript>
	<meta http-equiv="refresh" content="0; URL=<?php echo MainHelper::site_url('enable-js');?>">
</noscript>
*/?>

<div class="errorContainer dn"></div>

<!-- Header start -->
<header id="header" class="game_template_header">
	<?php include 'header.php'; ?>
</header>
<!-- Header end -->

<!-- Game template wrapper start -->
<div id="game_template_wrapper">
	<?php echo $data['content'];?>
</div>
<!-- Game template wrapper end -->

<!-- Twitch and Chat -->
<?php include 'bottombar.php'; ?>
</body>
</html>