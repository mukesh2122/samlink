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

<!-- The one column start -->
<div id="the_one_column">
	<?php echo $data['content'];?>
</div>
<!-- The one column start -->

<!-- Footer start -->
<footer id="footer">
	<?php include 'footer.php'; ?>
</footer>

<!-- Twitch and Chat -->
<?php include 'bottombar.php'; ?>
</body>
</html>