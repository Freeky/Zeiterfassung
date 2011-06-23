<?php
require_once(dirname(__FILE__) . "/../controls/base/AssignmentConnector.php");
require_once(dirname(__FILE__) . "/../controls/base/TaskConnector.php");
require_once(dirname(__FILE__) . "/../controls/admin/Controller.php");

session_start();

if(isset($_REQUEST['logout'])){
	session_destroy();
	session_start();
}

if(!isset($_SESSION['user']))
header('Location: index.php');

if(!isset($_REQUEST['id']))
header('Location: overview.php');
$ac = new AssignmentConnector;
$tc = new TaskConnector;

$assignment = $ac->getAssignmentByID(intval($_REQUEST['id']));

if(isset($_REQUEST['save-assignment'])){

	if($_REQUEST['assignment-name'] != "")
	$assignment->setName($_REQUEST['assignment-name']);

	if($_REQUEST['assignment-employer'] != "")
	$assignment->setEmployer($_REQUEST['assignment-employer']);

	$assignment->setDescription($_REQUEST['assignment-description']);

	$assignment->setStatus($_REQUEST['assignment-status']);

	if($_REQUEST['assignment-deadline'] != ""){
		$parsedDate = date_parse($_REQUEST['assignment-deadline']);
		if($parsedDate and $parsedDate['year'] > 0){
			$deadline = new DateTime();
			$deadline->setDate($parsedDate['year'],
			$parsedDate['month'],
			$parsedDate['day']);
			$assignment->setDeadline($deadline);
		}
	}else {
		$assignment->setDeadline(NULL);
	}

	$ac->saveAssignment($assignment);
}

$status = $assignment->getStatus();
$deadline = $assignment->getDeadline();

if(isset($_REQUEST['add-task'])) {
	if(isset($_REQUEST['task-name'])
	and isset($_REQUEST['task-status'])
	and isset($_REQUEST['task-starttime'])
	and isset($_REQUEST['task-endtime'])){
		
		$task = new Task;
		$task->setAssignmentRef($assignment->getID());
		$task->setUserRef($_SESSION['user']->getUID());
		$task->setName($_REQUEST['task-name']);
		$task->setDescription($_REQUEST['task-description']);
		$task->setStatus($_REQUEST['task-status']);
		
		if($_POST['task-starttime'] != ""){
			$parsedDate = date_parse($_POST['task-starttime']);
			if($parsedDate and $parsedDate['year'] > 0){
				$starttime = new DateTime();
				$starttime->setDate($parsedDate['year'],
				$parsedDate['month'],
				$parsedDate['day']);
				$starttime->setTime($parsedDate['hour'],
				$parsedDate['minute']);
				$task->setStarttime($starttime);
			}
		}
		
		if($_POST['task-endtime'] != ""){
			$parsedDate = date_parse($_POST['task-endtime']);
			if($parsedDate and $parsedDate['year'] > 0){
				$endtime = new DateTime();
				$endtime->setDate($parsedDate['year'],
				$parsedDate['month'],
				$parsedDate['day']);
				$endtime->setTime($parsedDate['hour'],
				$parsedDate['minute']);
				$task->setEndtime($endtime);
			}
		}
		
		$tc->saveTask($task);
	}
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
	<div id="menue">
		<form name="logout-form" method="post">
			<a href="overview.php"><span>Aufträge</span> </a> - Angemeldet als:
			<?php echo $_SESSION['user']->getName(); ?>
			<button name="logout">Abmelden</button>
		</form>
	</div>
	<br />
	<div class="column span-23">
		<form name="assignment-edit" method="post">
			<div class="column span-10">
				Name: <br /> <input name="assignment-name" type="text"
					style="width: 100%;"
					value="<?php echo htmlspecialchars($assignment->getName()); ?>"><br />
				Auftraggeber: <br /> <input name="assignment-employer" type="text"
					style="width: 100%;"
					value="<?php echo htmlspecialchars($assignment->getEmployer()); ?>"><br />
				Status: <br /> <select name="task-status" style="width: 100%">
					<option <?php if($status == "Planned") echo "selected"; ?>>Planned</option>
					<option <?php if($status == "In Progress") echo "selected"; ?>>In Progress</option>
					<option <?php if($status == "Done") echo "selected"; ?>>Done</option>
					<option <?php if($status == "Canceled") echo "selected"; ?>>Canceled</option>
				</select><br /> Anlagedatum: <br />
				<?php echo $assignment->getCreationDate()->format("d.m.Y"); ?>
				<br /> Stichtag: <br /> <input name="assignment-deadline"
					type="text" style="width: 100%;"
					value="<?php if(!is_null($deadline)) echo $deadline->format("d.m.Y"); ?>"><br />
			</div>
			<div class="column span-10">
				Beschreibung: <br />
				<textarea name="assignment-description"
					style="width: 100%; height: 150px;"><?php echo htmlspecialchars($assignment->getDescription()); ?></textarea>
				<br />
			</div>
			<div class="span-23">
				<button name="save-assignment" type="submit">Änderungen Speichern</button>
				<br /> <a href="rechnung/rechnung.php?jid=<?php echo $assignment->getID(); ?>">Rechnung als PDF</a><br/>
					<br />
					<h3>Aufgaben:</h3>
			</div>
		</form>

	</div>
	<hr>
	<div class="span-24">
			<table>
				<tr>
					<td width="30"></td>
					<td width="150">Name</td>
					<td width="100">Benutzer</td>
					<td width="300">Beschreibung</td>
					<td width="100">Status</td>
					<td width="100">Startzeit</td>
					<td width="100">Endzeit</td>
				</tr>
				<form name="entry-add-form" method="POST">
					<tr>
						<td><input name="add-task" type="submit" value="Add">
						</td>
						<td><input name="task-name" type="text" style="width: 100%">
						</td>
						<td><?php echo $_SESSION['user']->getName(); ?>
						</td>
						<td><input name="task-description" type="text" style="width: 100%">
						</td>
						<td><select name="task-status" style="width: 100%">
								<option>Planned</option>
								<option>In Progress</option>
								<option>Done</option>
								<option>Canceled</option>
						</select></td>
						<td><input name="task-starttime" type="text" style="width: 100%" value="<?php
						$now = new DateTime();
						echo $now->format("d.m.Y H:i"); ?>">
						</td>
						<td><input name="task-endtime" type="text" style="width: 100%" value="<?php
						$now = new DateTime();
						echo $now->format("d.m.Y H:i"); ?>">
						</td>
					</tr>
				</form>
				<?php					
					
				// Perform Query
				$tasks = $tc->searchTask(NULL, $assignment->getID());
				
				$controller = new Controller;
				foreach($tasks as $t) {
					$desc = explode("\n", $t->getDescription(), 2);
					$user = $controller->CreateUserObject($t->getUserRef());
					echo "<tr>
					<td></td>
					<td><a href='task.php?id=".$t->getID()."'>".$t->getName()."</a></td>
					<td>".$user->getName()."</td>
					<td>".$desc[0]."</td>
					<td>".$t->getStatus()."</td>
					<td>".$t->getStarttime()->format("d.m.Y H:i")."</td>
					<td>".$t->getEndtime()->format("d.m.Y H:i")."</td>
				</tr>";
				}

				?>

			</table>

		</div>
	
</body>
</html>
