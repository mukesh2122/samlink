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
<header id="header">
	<?php include 'header.php'; ?>
</header>
<!-- Header end -->

<!-- Main container start -->
<div id="container" class="clearfix">

	<!-- Main content start -->
	<div id="center_column_wide" class="column content_middle">
		<?php echo $data['content'];?>
	</div>
	<!-- Main content end -->

	<!-- Right column start -->
	<aside id="right_column" class="column">
		<?php echo isset($data['right']) ? $data['right'] : '';?>
	</aside>
	<!-- Right column end -->

</div>
<!-- Main container end -->

<!-- Footer start -->
<footer id="footer">
	<?php include 'footer.php'; ?>
</footer>

<!-- Twitch and Chat -->
<?php include 'bottombar.php'; ?>
</body>
</html>