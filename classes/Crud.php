<?php
require 'Pdo_methods.php';

class Crud extends PdoMethods{

	public function getFiles($type){
		
		/* CREATE AN INSTANCE OF THE PDOMETHODS CLASS*/
		$pdo = new PdoMethods();

		/* CREATE THE SQL */
		$sql = "SELECT * FROM files";

		//PROCESS THE SQL AND GET THE RESULTS
		$records = $pdo->selectNotBinded($sql);

		/* IF THERE WAS AN ERROR DISPLAY MESSAGE */
		if($records == 'error'){
			return 'There has been and error processing your request';
		}
		else {
			if(count($records) != 0){
				if($type == 'list'){return $this->createList($records);}
				if($type == 'input'){return $this->createInput($records);}	
			}
			else {
				return 'no files found';
			}
		}
	}

	public function addFile(){
	
		$pdo = new PdoMethods();

		/* HERE I CREATE THE SQL STATEMENT I AM BINDING THE PARAMETERS */
		$sql = "INSERT INTO files (file_name, file_path) VALUES (:file_name, :file_path)";

			 
	    /* THESE BINDINGS ARE LATER INJECTED INTO THE SQL STATEMENT THIS PREVENTS AGAIN SQL INJECTIONS */
	    $bindings = [
			[':file_name',$_POST['file_name'],'str'],
			[':file_path',$_POST['file_path'],'str']
		];

		/* I AM CALLING THE OTHERBINDED METHOD FROM MY PDO CLASS */
		$result = $pdo->otherBinded($sql, $bindings);

		/* HERE I AM RETURNING EITHER AN ERROR STRING OR A SUCCESS STRING */
		if($result === 'error'){
			return 'There was an error adding the file';
		}
		else {
			return 'File has been added';
		}
	}

	public function updateFiles($post){
		$error = false;

		if(isset($post['inputDeleteChk'])){

			foreach($post['inputDeleteChk'] as $id){
				$pdo = new PdoMethods();

				/* HERE I CREATE THE SQL STATEMENT I AM BINDING THE PARAMETERS */
				$sql = "UPDATE files SET file_name = :file_name, file_path = :file_path WHERE file_id = :file_id";

				//THE ^^ WAS USED TO MAKE EACH ITEM UNIQUE BY COMBINING FNAME WITH THEY ID
				$bindings = [
					[':file_name', $post["file_name^^{$id}"], 'str'],
					[':file_path', $post["file_[path^^{$id}"], 'str']
				];

				$result = $pdo->otherBinded($sql, $bindings);

				if($result === 'error'){
					$error = true;
					break;
				}
				
			}

			if($error){
				return "There was an error in updating a file or files";
			}
			else {
				return "All files updated";
			}
		}
		else {
			return "No files selected to update";
		}
	}

	public function deleteFiles($post){
		$error = false;
		if(isset($post['inputDeleteChk'])){
			foreach($post['inputDeleteChk'] as $id){
				$pdo = new PdoMethods();

				$sql = "DELETE FROM files WHERE file_id=:file_id";
				
				$bindings = [
					[':file_id', $id, 'int'],
				];


				$result = $pdo->otherBinded($sql, $bindings);

				if($result === 'error'){
					$error = true;
					break;
				}
			}
			if($error){
				return "There was an error in deleting a file or files";
			}
			else {
				return "All files deleted";
			}

		}
		else {
			return "No files selected to delete";
		}
	}

	/*THIS FUNCTION TAKES THE DATA FROM THE DATABASE AND RETURN AN UNORDERED LIST OF THE DATA*/
	private function createList($records){
		$list = '<ol>';
		foreach ($records as $row){
			$list .= "<li><a target='_blank' href='{$row['file_path']}'>{$row['file_name']}</a></li>";
		}
		$list .= '</ol>';
		return $list;
	}

	/*THIS FUNCTION TAKES THE DATA AND RETURNS THE DATA IN INPUT ELEMENTS SO IT CAN BE EDITED.  */
	private function createInput($records){
		$output = "<form method='post' action='update_delete_files.php'>";
		$output .= "<input class='btn btn-success' type='submit' name='update' value='Update'>";
		$output .= "<input class='btn btn-danger' type='submit' name='delete' value='Delete'>";
		$output .= "<table class='table table-bordered table-striped'><thead><tr>";
		$output .= "<th>File Name</th><th>File Path</th><th>Update/Delete</th><tbody>";
		foreach ($records as $row){
			$output .= "<tr><td><input type='text' class='form-control' name='file_name^^{$row['file_id']}' value='{$row['file_name']}'></td>";

			$output .= "<td><input type='text' class='form-control' name='file_path^^{$row['file_id']}' value='{$row['file_path']}'></td>";

			$output .= "<td><input type='checkbox' name='inputDeleteChk[]' value='{$row['file_id']}'></td></tr>";
		}
		
		$output .= "</tbody></table></form>";
		return $output;
	}
}