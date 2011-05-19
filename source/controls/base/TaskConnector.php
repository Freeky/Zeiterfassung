<?php
	require_once '../conf/connect_db.inc';
	require_once 'Task.php';
	
	class TaskConnector {
		
		public function getTaskByID($id) {
			//query
			//process result
		}
		
		public function searchTask($name = NULL, 
										$description = NULL, 
										$employer = NULL, 
										$minCreationDate = NULL, 
										$maxCreationDate = NULL,
										$minDeadline = NULL, 
										$maxDeadline = NULL,
										$status = NULL) {
			//Paramevaluation here#
			//Konstrukt/execute query
			//process result
		}
		
		public function saveTask($task) {
			//save to database
		}
	}
?>