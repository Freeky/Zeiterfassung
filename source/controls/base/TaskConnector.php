<?php
	require_once(dirname(__FILE__) . "/../conf/connect_db.inc");
	require_once(dirname(__FILE__) . "/Task.php");
	
	class TaskConnector {
		
		public function getTaskByID($id) {
			//query
			$id = mysql_escape_string($id);
			$query = "Select id, userref, assignmentref, name, description, starttime, endtime, status from task where id = $id;";
			$resource = mysql_query($query);
			
			$result = mysql_fetch_array($resource);
			
			//process result
			return $this->resultToTask($result);
		}
		
		public function searchTask($userref = NULL, 
										$assignmentref = NULL,
										$name = NULL, 
										$description = NULL, 
										$minStarttime = NULL, 
										$maxStarttime = NULL,
										$minEndtime = NULL, 
										$maxEndtime = NULL,
										$status = NULL) {
			
			//evaluate and create query string
			$query = "select id, userref, assignmentref, name, description, starttime, endtime, status from task where 1=1 ";
			
			if(!is_null($userref)){
				$query = $query."and userref = ".mysql_real_escape_string($userref)." ";
			}
			
			if(!is_null($assignmentref)){
				$query = $query."and assignmentref = ".mysql_real_escape_string($assignmentref)." ";
			}
			
			if(!is_null($name)) {
				$query = $query."and name like '%".mysql_real_escape_string($name)."%' ";
			}
			
			if(!is_null($description)) {
				$query = $query."and description like '%".mysql_real_escape_string($description)."%' ";
			}
			
			if(!is_null($minStarttime)) {
				$query = $query."and starttime >= '".mysql_real_escape_string($minStarttime->format("Y-m-d H:i:s"))."' ";
			}
			
			if(!is_null($maxStarttime)) {
				$query = $query."and starttime <= '".mysql_real_escape_string($maxStarttime->format("Y-m-d H:i:s"))."' ";
			}
			
			if(!is_null($minEndtime)) {
				$query = $query."and endtime >= '".mysql_real_escape_string($minEndtime->format("Y-m-d H:i:s"))."' ";
			}
			
			if(!is_null($maxEndtime)) {
				$query = $query."and endtime <= '".mysql_real_escape_string($maxEndtime->format("Y-m-d H:i:s"))."' ";
			}
			
			if(is_array($status)) {
				$query = $query."and ( 1=0 ";
				foreach($status as $s) {
					$query = $query."or status = '".mysql_real_escape_string($s)."' ";
				}
				$query = $query.") ";
			}
			
			
			//process result
			$resource = mysql_query($query);
			
			$tasks = array();
			if(!$resource)
				return $tasks;
			
			while($result = mysql_fetch_array($resource)){
				$tasks[] = $this->resultToTask($result);
			}
			
			return $tasks;
		}
		
		public function saveTask($task) {
			
			if(!(get_class($task) == "Task")) {
				throw new Exception("saveTask needs an Argument of type Task");
			}
			
			if(is_null($task->getUserRef()) or 
			   is_null($task->getAssignmentRef()) or
			   is_null($task->getName()) or 
			   is_null($task->getStarttime()) or 
			   is_null($task->getEndtime()) or
			   is_null($task->getStatus())) {
			   	throw new Exception("saveAssignment received an invalid Assignment");
			}
			
			if($task->getID() <= 0) {
				// Datensatz anlegen
				$query = "insert into task (userref, assignmentref, name, description, starttime, endtime, status) values (";
				
				$query = $query.mysql_real_escape_string($task->getUserRef()).", ";
				
				$query = $query.mysql_real_escape_string($task-> getAssignmentRef()).", ";
				
				$query = $query."'".mysql_real_escape_string($task->getName())."', ";
				
				if(is_null($task->getDescription()))
					$query = $query."NULL, ";
				else 
					$query = $query."'".mysql_real_escape_string($task->getDescription())."', ";
					
				$query = $query."'".mysql_real_escape_string($task->getStarttime()->format("Y-m-d H:i:s"))."', ";
				
				$query = $query."'".mysql_real_escape_string($task->getEndtime()->format("Y-m-d H:i:s"))."', ";
				
				$query = $query."'".mysql_real_escape_string($task->getStatus())."')";
				
				mysql_query($query);
				
				if(mysql_affected_rows() != 1)
					Throw new Exception("Fehler beim Einfügen der Daten(".mysql_affected_rows()."): ".mysql_error());
			} else {
				// Datensatz updaten
				
				$query = "update task set ";
				
				$query = $query."userref = ".mysql_real_escape_string($task->getUserRef()).", ";
				
				$query = $query."assignmentref = ".mysql_real_escape_string($task->getAssignmentRef()).", ";
				
				$query = $query."name = '".mysql_real_escape_string($task->getName())."', ";
				
				if(is_null($task->getDescription()))
					$query = $query."description = NULL, ";
				else 
					$query = $query."description = '".mysql_real_escape_string($task->getDescription())."', ";
					
				$query = $query."starttime = '".mysql_real_escape_string($task->getStarttime()->format("Y-m-d H:i:s"))."', ";
				
				$query = $query."endtime = '".mysql_real_escape_string($task->getEndtime()->format("Y-m-d H:i:s"))."', ";
				
				$query = $query."status = '".mysql_real_escape_string($task->getStatus())."' ";
				
				$query = $query."where id = ".$task->getID();
				
				mysql_query($query);
				
				if(!(mysql_affected_rows() <= 1) and !(mysql_affected_rows() >= 0))
					Throw new Exception("Fehler beim Einfügen der Daten(".mysql_affected_rows()."): ".mysql_error());
			}
			//save to database
			
		}
		
		private function deleteTask($id){
			if(!is_int($id) or $id <= 0){
				Throw new Exception("deleteTask hat keine gültige ID erhalten");
			}
			
			$id = mysql_escape_string($id);
			$query = "delete from task where id = $id;";
			
			mysql_query($query);
			
			if(mysql_affected_rows() != 1) {
				Throw new Exception("Datensatz konnte nicht gelöscht werden");
			}
		}
		
		
		private function resultToTask($result) {
			$task = new Task;
			$task->setID($result['id']);
			$task->setAssignmentRef($result['assignmentref']);
			$task->setUserRef($result['userref']);
			$task->setName($result['name']);
			$task->setDescription($result['description']);
			$task->setStarttime(new DateTime($result['starttime']));
			$task->setEndtime(new DateTime($result['endtime']));
			$task->setStatus($result['status']);
			
			return $task;
		}
	}
?>