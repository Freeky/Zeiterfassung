<?php
	require_once '../conf/connect_db.inc';
	require_once 'Assignment.php';
	
	class AssignmentConnector {
		
		public function getAssignmentByID($id) {
			//query
			//process result
		}
		
		public function searchAssignment($name = NULL, 
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
		
		public function saveAssignment($assignment) {
			//save to database
		}
	}
?>