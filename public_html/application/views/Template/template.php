<?php
	defined('BASEPATH') OR die('No direct access allowed.');
?>

<!DOCTYPE html>

<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="/~depsked/assets/fontawesome-free-6.0.0-web/css/all.css">
<script
	src="https://code.jquery.com/jquery-2.2.4.min.js"
	integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
	crossorigin="anonymous">
</script>
<script type = "text/JavaScript" src = " https://MomentJS.com/downloads/moment.js"></script>
	<title>
		<?php echo html_escape($title); ?>
	</title>
</head>

<body>

	<?php 
		$url = $_SERVER['REQUEST_URI'];
	?>

	<div class="main" id="main">
    
    <?php $this->load->view($page,$data); ?>

	</div>
	
</body>
</html>