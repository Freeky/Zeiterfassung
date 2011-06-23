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
$controller = new Controller;

$task = $tc->getTaskByID(intval($_REQUEST['id']));
$assignment = $ac->getAssignmentByID(intval($task->getAssignmentRef()));
$taskuser = $controller->CreateUserObject(intval($task->getUserRef()));
$status = $task->getStatus();
$starttime = $task->getStarttime();
$endtime = $task->getEndtime();

if(isset($_REQUEST['save-task'])){
	try {
		$task->setUserRef($_SESSION['user']->getUID());
		
		if(isset($_REQUEST['task-name']))
			$task->setName($_REQUEST['task-name']);
			
		if(isset($_REQUEST['task-status']))
			$task->setStatus($_REQUEST['task-status']);
			
		$task->setDescription($_REQUEST['task-description']);
		
		if($_REQUEST['task-starttime'] != ""){
			$parsedDate = date_parse($_REQUEST['task-starttime']);
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
		
		if($_REQUEST['task-endtime'] != ""){
			$parsedDate = date_parse($_REQUEST['task-endtime']);
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
	
	} catch (Exception $ex) {
		echo "Beim Einfügen ist ein Fehler aufgetreten: $ex <br />";
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
				Name: <br /> <input name="task-name" type="text"
					style="width: 100%;"
					value="<?php echo htmlspecialchars($task->getName()); ?>"><br />
				Auftrag: <br />
				<a href="assignment.php?id=<?php echo $assignment->getID(); ?>"><?php echo htmlspecialchars($assignment->getName()); ?></a><br />
				Benutzer: <br /> 
				<?php echo htmlspecialchars($taskuser->getName()); ?> <br />
				Status: <br /> <select name="task-status" style="width: 100%">
					<option <?php if($status == "Planned") echo "selected"; ?>>Planned</option>
					<option <?php if($status == "In Progress") echo "selected"; ?>>In
						Progress</option>
					<option <?php if($status == "Done") echo "selected"; ?>>Done</option>
					<option <?php if($status == "Canceled") echo "selected"; ?>>Canceled</option>
				</select><br /> Startzeit: <br />
				<input name="task-starttime" type="text" style="width: 100%;"
					value="<?php if(!is_null($starttime)) echo $starttime->format("d.m.Y H:i"); ?>">
				<br /> Stichtag: <br /> <input name="task-endtime"
					type="text" style="width: 100%;"
					value="<?php if(!is_null($endtime)) echo $endtime->format("d.m.Y H:i"); ?>"><br />
			</div>
			<div class="column span-10">
				Beschreibung: <br />
				<textarea name="task-description"
					style="width: 100%; height: 150px;"><?php echo htmlspecialchars($task->getDescription()); ?></textarea>
				<br />
			</div>
			<div class="span-23">
				<button name="save-task" type="submit">Änderungen Speichern</button>
			</div>
		</form>
	</div>
</body>
</html>