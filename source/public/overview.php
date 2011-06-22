<?php
require_once(dirname(__FILE__) . "/../controls/base/OverviewFilter.php");
require_once(dirname(__FILE__) . "/../controls/base/AssignmentConnector.php");

session_start();

if(!isset($_SESSION['user']))
	header('Location: index.php');

if(!isset($_SESSION['filter']))
	$_SESSION['filter'] = new OverviewFilter();

if(isset($_POST['filter-button'])){
	$_SESSION['filter']->setName($_POST['filter-name']);
	$_SESSION['filter']->setEmployer($_POST['filter-client']);
	$_SESSION['filter']->setDescription($_POST['filter-description']);
	$_SESSION['filter']->setCreatedateFrom($_POST['filter-createdate-from']);
	$_SESSION['filter']->setCreatedateTo($_POST['filter-createdate-to']);
	$_SESSION['filter']->setDeadlineFrom($_POST['filter-deadline-from']);
	$_SESSION['filter']->setDeadlineTo($_POST['filter-deadline-to']);
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
</head>

<body>
	<div class="column span-5">
		<h2>Filter</h2>
		<form name="filter-form" method="POST">
			<button name="filter-button" value="1" type="submit">Filter anwenden</button><br /> 
			Name: <br />
			<input name="filter-name" type="text" value="<?php echo $_SESSION['filter']->getName(); ?>"> <br />
			Auftraggeber: <br /> 
			<input name="filter-client" type="text"	value="<?php echo $_SESSION['filter']->getEmployer(); ?>"> <br />
			Beschreibung: <br /> 
			<input name="filter-description" type="text"	value="<?php echo $_SESSION['filter']->getDescription(); ?>"> <br />
			Anlagedatum Von: <br /> 
			<input name="filter-createdate-from" type="text" value="<?php echo $_SESSION['filter']->getCreatedateFrom()->format("d.m.Y"); ?>"> <br /> 
			Anlagedatum Bis: <br />
			<input name="filter-createdate-to" type="text" value="<?php echo $_SESSION['filter']->getCreatedateTo()->format("d.m.Y"); ?>"> <br />
			Stichtag Von: <br /> 
			<input name="filter-deadline-from" type="text" value="<?php echo $_SESSION['filter']->getDeadlineFrom()->format("d.m.Y"); ?>"> <br /> 
			Stichtag Bis: <br />
			<input name="filter-deadline-to" type="text" value="<?php echo $_SESSION['filter']->getDeadlineTo()->format("d.m.Y"); ?>"> <br />
			Status: <br /> 
			<input type="checkbox" name="filter-planned" <?php if($_SESSION['filter']->getPlanned()) echo "checked"; ?> value="true">Planned<br />
			<input type="checkbox" name="filter-in-progress" <?php if($_SESSION['filter']->getInprogress()) echo "checked"; ?> value="true">In Progress<br />
			<input type="checkbox" name="filter-done" <?php if($_SESSION['filter']->getDone()) echo "checked"; ?> value="true">Done<br />
			<input type="checkbox" name="filter-canceled" <?php if($_SESSION['filter']->getCanceled()) echo "checked"; ?> value="true">Canceled<br />
		</form>
	</div>
	<div class="column span-23">
		<div id="menue">
			<a href="overview.php"><span>Aufträge</span></a> - 
			<a href="tasks.php"><span>Aufgaben</span></a>
		</div>
		<br />
		<div>
			<table>
				<tr>
					<td width="30"></td>
					<td width="150">Name</td>
					<td width="100">Auftraggeber</td>
					<td width="300">Beschreibung</td>
					<td width="100">Status</td>
					<td width="100">Anlagedatum</td>
					<td width="100">Stichtag</td>
				</tr>
				<form name="entry-add-form" method="POST">
					<tr>
						<td><input name="add-assignment" type="submit" value="Add">
						</td>
						<td><input name="name" type="text" style="width: 100%">
						</td>
						<td><input name="client" type="text" style="width: 100%">
						</td>
						<td><input name="description" type="text" style="width: 100%">
						</td>
						<td><select name="status" style="width: 100%">
								<option>Planned</option>
								<option>In Progress</option>
								<option>Done</option>
								<option>Canceled</option>
						</select></td>
						<td><input name="creationdate" type="text" style="width: 100%">
						</td>
						<td><input name="deadline" type="text" style="width: 100%">
						</td>
					</tr>
				</form>
				<?php 
					//Setup Query params and objects
					$ac = new AssignmentConnector;
					
					$name = NULL;
					if($_SESSION['filter']->getName() != "") {
						$name = $_SESSION['filter']->getName();
					}
					
					$employer = NULL;
					if($_SESSION['filter']->getEmployer() != "") {
						$employer = $_SESSION['filter']->getEmployer();
					}
					
					$description = NULL;
					if($_SESSION['filter']->getDescription() != "") {
						$description = $_SESSION['filter']->getDescription();
					}
					
					$status = array();
					if($_SESSION['filter']->getPlanned()) {
						$status[] = "Planned";
					}
					if($_SESSION['filter']->getInprogress() != "") {
						$status[] = "In Progress";
					}
					if($_SESSION['filter']->getDone() != "") {
						$status[] = "Done";
					}
					if($_SESSION['filter']->getCanceled() != "") {
						$status[] = "Canceled";
					}
					
					// Perform Query
					$assignments = $ac->searchAssignment($name, 
										$employer, 
										$description, 
										$_SESSION['filter']->getCreatedateFrom(), 
										$_SESSION['filter']->getCreatedateTo(),
										$_SESSION['filter']->getDeadlineFrom(), 
										$_SESSION['filter']->getDeadlineTo(),
										$status);
					
					//Result printout
										
				?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>				
				</tr>
			</table>

		</div>

	</div>
</body>
</html>
