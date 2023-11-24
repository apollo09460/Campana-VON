<?php
require_once('Controller.php');


$taskManager = new TaskManager();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['addTask'])) {
        $taskName = $_POST['taskName'];
        $selectedOption = $_POST["myDropdown"];


        $taskManager->addTask($taskName,$selectedOption);

  
    }

     elseif (isset($_POST['markDone'])) {
        $taskId = $_POST['taskId'];
        $taskManager->markTaskAsDone($taskId);
    }
    elseif(isset($_POST['deleteSelectedUser'])){

        $users = $_POST['newUsername'];

        $taskManager->deleteuser($users);
        
       }
       elseif(isset($_POST['addUser'])){

        $users = $_POST['newUsername'];

        $taskManager->adduser($users);
  }  
  
  elseif (isset($_POST["myDropdown"])) {
    // Echo the selected option
    $selectedOption = $_POST["myDropdown"];
    $taskManager->drop($selectedOption);



   $text = "Current User: $selectedOption";
     echo '<p style="text-align: Center; font-weight: bold;">' . $text . '</p>';


    $valve = $taskManager->drop($selectedOption);


 
}

}

$tasks = $taskManager->getTasks();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
      

</head>
 
<body>

<form action="" method="post" style="margin-left: 300px;">
   
</form>



<!-- Add and Delete User form -->
<div class="container mt-3 text-center">
    <form method="post">
        <label for="newUsername" class="form-label">New User</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="newUsername" name="newUsername" placeholder="New User" aria-label="New User" aria-describedby="button-addon4">
            <button type="submit" class="btn btn-success" name="addUser" type="button" id="button-addon4">Add User</button>
            <button type="submit" class="btn btn-danger" name="deleteSelectedUser" type="button" id="button-addon5">Delete Selected User</button>
        </div>
    </form>
</div>

    <div class="container mt-5">
        <form method="post" class="mt-5">
 <select name="myDropdown">
        <?php

         $valve = $taskManager->drop($selectedOption);
            // Your array of values
            $myArray = $valve;

            // Loop through the array and create an option element for each value
            foreach ($myArray as $value) {
                echo "<option value=\"$value\">$value</option>";
            }
        ?>
    </select>
    


            <label for="taskName" class="form-label">USER</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="taskName" name="taskName" placeholder="Task" aria-label="Task" aria-describedby="button-addon2">
                <button type="submit" class="btn btn-primary" name="addTask" type="button" id="button-addon2">Button</button>
            </div>
        </form>

        <h3>Tasks</h3>
        <ul class="list-group">
            <?php foreach ($tasks as $task) : ?>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="col">
                        <small>ID: <?php echo $task['taskId'] ?></small>
                        <small>By: <?php echo $task['username'] ?></small>
                        <h5 class="mb-1">Task: <?php echo $task['taskName']; ?></h5>
                    </div>
                    <form method="post">
                        <input type="hidden" name="taskId" value="<?php echo $task['taskId']; ?>">
                        <button type="submit" class="btn <?php echo $task['is_done'] ? 'btn-success' : 'btn-danger'; ?> btn-sm" name="markDone"><?php echo $task['is_done'] ? 'Done' : 'Pending'; ?></button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
