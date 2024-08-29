<!DOCTYPE html>
<html ng-app='page_app'>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>System Management</title>
	<!-- <link href="https://fonts.googleapis.com/css?family=Raleway|Montserrat" rel="stylesheet"> -->
</head>
<link rel="stylesheet" href="<?= base_url('assets/css/admin/') ?>colors.css">
<!-- <link rel="stylesheet" href="<?= base_url('assets/css/') ?>layout.min.css"> -->
<link rel="stylesheet" href="<?= base_url('assets/css/') ?>structure.min.css">
<link rel="stylesheet" href="<?= base_url('assets/lib/css/') ?>bootstrap.min.css">
<link rel="icon" type="image/png" href="<?= base_url() ?>assets/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="<?= base_url() ?>assets/favicon-16x16.png" sizes="16x16" />

<body ng-controller='page_controller' ng-init="base_url='<?= base_url(); ?>'">
	<div></div>
	<div class="wrapper">
		<?php $this->load->view('./layouts/topmenu') ?>
		<div class="container-fluid">
			<?php
			// $this->load->view('layouts/admins/topmenu');
			?>
			<div class="mb-4"></div>
			<?php
			$this->load->view($page);
			$this->load->view('layouts/admins/footer');
			?>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/lib/js/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/lib/js/angular.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/admin/<?= $angular; ?>.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/admin/login_control.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin/design.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin/menuit.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin/forms.css">

</body>

</html>