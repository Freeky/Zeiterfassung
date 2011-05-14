<?php
	require_once './controls/base/OverviewFilter.php';
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
</head>

<body>
	<div class="column span-5">
		<h2>Filter</h2>
		<form name="filter-form" method="POST">
		    <button type="submit">Filter anwenden</button><br />
			Von: <br />
			<input name="filter-from" type="text" 
				value="<?php echo $_SESSION['filter']->getFrom(); ?>"> <br />
			Bis: <br />
			<input name="filter-to" type="text" 
				value="<?php echo $_SESSION['filter']->getTo(); ?>"> <br />
			Auftraggeber: <br />
			<input name="filter-client" type="text" 
				value="<?php echo $_SESSION['filter']->getClient(); ?>"> <br />
			Status: <br />
			<input type="checkbox" name="filter-planned" 
				<?php if($_SESSION['filter']->getPlanned()) echo "checked"; ?> 
				value="true">Planned<br />
			<input type="checkbox" name="filter-in-progress" 
				<?php if($_SESSION['filter']->getInprogress()) echo "checked"; ?> 
				value="true">In Progress<br />
			<input type="checkbox" name="filter-done" 
				<?php if($_SESSION['filter']->getDone()) echo "checked"; ?> 
				value="true">Done<br />
			<input type="checkbox" name="filter-canceled" 
				<?php if($_SESSION['filter']->getCanceled()) echo "checked"; ?> 
				value="true">Canceled<br />
		</form>
	</div>
	<div class="column">
		<table>
			<tr>
				<td width="30">ID</td>
				<td width="100">Datum</td>
				<td width="200">Auftraggeber</td>
				<td width="300">Beschreibung</td>
				<td width="100">Status</td>
				<td width="50">Zeit</td>
			</tr>
			<form name="entry-add-form" method="POST">
				<tr>
					<td><input type="image" src="new.png"></td>
					<td><input name="date" type="text" style="width: 100%"></td>
					<td><input name="client" type="text" style="width: 100%"></td>
					<td><input name="description" type="text" style="width: 100%"></td>
					<td>
						<select name="date" style="width: 100%">
					   		<option>Planned</option>
					   		<option>In Progress</option>
					   		<option>Done</option>
					   		<option>Canceled</option>
						</select>
					</td>
					<td><input name="time" type="text" style="width: 100%"></td>
				</tr>
			</form>
			<tr>
				<td><a href="editentry.php"><img src="edit.png" /></a></td>
				<td>19-02-2011</td>
				<td>Hochschule</td>
				<td>Doing some REALY crazy shit</td>
				<td>DONE</td>
				<td>2.5</td>
			</tr>
			<tr>
				<td><img src="edit.png" /></td>
				<td>18-02-2011</td>
				<td>Hochschule</td>
				<td>Doing some REALY crazy shit</td>
				<td>DONE</td>
				<td>2.5</td>
			</tr>
			<tr>
				<td><a href="editentry.php"><img src="edit.png" /></a></td>
				<td>18-02-2011</td>
				<td>Google</td>
				<td>Doing some REALY crazy shit</td>
				<td>DONE</td>
				<td>2.5</td>
			</tr>
			<tr>
				<td><a href="editentry.php"><img src="edit.png" /></a></td>
				<td>16-02-2011</td>
				<td>Hochschule</td>
				<td>Doing some REALY crazy shit</td>
				<td>DONE</td>
				<td>2.5</td>
			</tr>
			<tr>
				<td><a href="editentry.php"><img src="edit.png" /></a></td>
				<td>11-02-2011</td>
				<td>Hochschule</td>
				<td>Doing some REALY crazy shit</td>
				<td>DONE</td>
				<td>2.5</td>
			</tr>
		</table>
	</div>
</body>
</html>