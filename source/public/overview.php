<?php
require_once(dirname(__FILE__) . "/../controls/base/OverviewFilter.php");
session_start();
 
if(!isset($_SESSION['filter']))
$_SESSION['filter'] = new OverviewFilter();

if(!empty($_POST['filter-form'])){
	$_SESSION['filter']->setFrom($_POST['filter-from']);
	$_SESSION['filter']->setTo($_POST['filter-to']);
	$_SESSION['filter']->setClient($_POST['filter-client']);
	$_SESSION['filter']->setPlanned(isset($_POST['filter-planned']));
	$_SESSION['filter']->setInprogress(isset($_POST['filter-in-progress']));
	$_SESSION['filter']->setDone(isset($_POST['filter-done']));
	$_SESSION['filter']->setCanceled(isset($_POST['filter-canceled']));
}


?>
<html>
<head>
<link href="./css/screen.css" media="screen" rel="stylesheet"
	type="text/css" />
<link type="text/css"
	href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
  $("#tabview").tabs();
 });
</script>
</head>

<body>
	<div class="column span-5">
		<h2>Filter</h2>
		<form name="filter-form" method="POST">
			<button type="submit">Filter anwenden</button>
			<br /> Von: <br /> <input name="filter-from" type="text"
				value="<?php echo $_SESSION['filter']->getFrom(); ?>"> <br /> Bis: <br />
			<input name="filter-to" type="text"
				value="<?php echo $_SESSION['filter']->getTo(); ?>"> <br />
			Auftraggeber: <br /> <input name="filter-client" type="text"
				value="<?php echo $_SESSION['filter']->getClient(); ?>"> <br />
			Status: <br /> <input type="checkbox" name="filter-planned"
			<?php if($_SESSION['filter']->getPlanned()) echo "checked"; ?>
				value="true">Planned<br /> <input type="checkbox"
				name="filter-in-progress"
				<?php if($_SESSION['filter']->getInprogress()) echo "checked"; ?>
				value="true">In Progress<br /> <input type="checkbox"
				name="filter-done"
				<?php if($_SESSION['filter']->getDone()) echo "checked"; ?>
				value="true">Done<br /> <input type="checkbox"
				name="filter-canceled"
				<?php if($_SESSION['filter']->getCanceled()) echo "checked"; ?>
				value="true">Canceled<br />
		</form>
	</div>
	<div class="column span-23">
		<div id="tabview">
			<ul>
				<li><a href="base/assignments.php"><span>Aufträge</span> </a></li>
				<li><a href="base/tasks.php"><span>Aufgaben</span> </a></li>
				<li><a href="#fragment-3"><span>TempTab</span> </a></li>
			</ul>
			<div id="fragment-3">Hier könnte ihre Werbung stehen</div>
		</div>
	</div>
</body>
</html>
