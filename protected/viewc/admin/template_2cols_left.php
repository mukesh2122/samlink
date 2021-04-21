<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="no-js">
<head>
	<?php include "head.php"; ?>
</head>
<body class="<?php echo isset($data['body_class']) ? $data['body_class'] : '';?>">

<noscript>
	<meta http-equiv="refresh" content="0; URL=<?php echo MainHelper::site_url('enable-js');?>" />
</noscript>

<div class="errorContainer dn"></div>

<!-- Header start -->
<header id="header">
	<?php include "header.php"; ?>
</header>
<!-- Header end -->

<!-- Main container start -->
<div id="container" class="clearfix">

	<!-- Left column start -->
	<aside id="left_column" class="column">
		<?php echo isset($data['left']) ? $data['left'] : '';?>
	</aside>
	<!-- Left column end -->

	<!-- Main content start -->
	<div id="center_column_wide_left_admin" class="column content_middle">
		<?php echo $data['content'];?>
	</div>
	<!-- Main content end -->

</div>
<!-- Main container end -->

<!-- Footer start -->
<footer id="footer">
	<?php include "footer.php"; ?>
</footer>
<!-- Footer end -->

</body>
</html>