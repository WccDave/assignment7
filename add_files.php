<?php 
require_once 'classes/Page.php';
require_once 'classes/Crud.php';
$page = new Page();
$crud = new Crud();

$output = "";

if(isset($_POST['addFile'])){
  $output = $crud->addFile();
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>Add Files</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">

    
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Home Page</h1>
        <?php echo $page->nav(); ?>
      </header>
      
      <main>
        
          <p>Fill out all the fields and click the "Add File" button.</p>
          <p><?php echo $output; ?></p>
        
          <form method="post" action="add_files.php">
        <div class="input-group my-5">
            <input placeholder="File Name" type="text" class="form-control" name="file_name" id="file_name">
        </div>
        <div class="input-group my-5">
            <input type="file" class="form-control" id="file_path" name="file_path"> 
            <input class="input-group-text" type="submit" name="addFile" id="addFile" value="Add File"></input>
        </div>
        </form>
        
        
        
      </main>

    </div>
    

    <script src="../public/js/main.js"></script>
  </body>
</html>