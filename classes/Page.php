<?php

class Page {
	public function nav(){
		$nav = <<<NAV
      <nav>
        <ul>
          <li><a href="index.php">File Names List</a></li>
          <li><a href="add_files.php">Add Files</a></li>
          
        </ul>
      </nav>
NAV;
		return $nav;
	}
}
/*<li><a href="update_delete_files.php">Update/Delete Files</a></li>*/