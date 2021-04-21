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

<!-- Main container start -->
<div id="esport_container" class="clearfix">
	<!-- Main content start -->
		<?php echo $data['content']; ?>
	<!-- Main content end -->
</div>
<!-- Main container end -->

<?php /*
<!-- Chat wrapper start -->
<div id="chat_wrapper" class="clearfix">
	<?php include 'chat.php'; ?>
</div>
<!-- Chat wrapper end -->
*/ ?>
</body>
</html>