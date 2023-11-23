<?php
require_once('Controller.php');

$taskManager = new TaskManager();

// Database connection details
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTask'])) {
        $taskName = $_POST['taskName'];
        $taskManager->addTask($taskName);
    } elseif (isset($_POST['markDone'])) {
        $taskId = $_POST['taskId'];
        $taskManager->markTaskAsDone($taskId);
    } elseif (isset($_POST['addUser'])) {
        $username = $_POST['username'];

        // SQL query to insert user into the database
        $sql = "INSERT INTO users (username) VALUES ('$username')";

        if ($conn->query($sql) === TRUE) {
            echo "User added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['deleteUser'])) {
        $usernameToDelete = $_POST['username'];
        
        // SQL query to delete user from the database
        $sql = "DELETE FROM users WHERE username = '$usernameToDelete'";

        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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


<!-- Add new form for username -->
<form method="post" class="mt-3">
    <label for="username" class="form-label">Username</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-label="Username" aria-describedby="button-addon3">
        <button type="submit" class="btn btn-success" name="addUser" type="button" id="button-addon3">Add</button>
        <button type="submit" class="btn btn-danger" name="deleteUser" type="button" id="button-addon4">Delete</button>
    </div>
</form>
    
    <div class="container mt-5">
        <form method="post" class="mt-5">
            <label for="taskName" class="form-label">New Task</label>
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
