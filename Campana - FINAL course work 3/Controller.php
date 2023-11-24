<?php

class Database
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $name = 'tms';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
    
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function establishConnection()
    {
        return $this->conn;
    }
}

class TaskManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

   

    public function addTask($taskName,$selectedOption)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO tasks (taskName,username) VALUES ('$taskName','$selectedOption')");
       
        $query->execute();
        $query->close();
    }

    public function adduser($users)
    {

        $conn = $this->db->establishConnection();

        $query = $conn->prepare("INSERT INTO users (username) VALUES ('$users')");
        $query->execute();
        $query->close();
        
    }

    public function deleteuser($users)
    {
        
        $conn = $this->db->establishConnection();

        $query = $conn->prepare("DELETE FROM users WHERE username = '$users'");
        $query->execute();
        $query->close();
           
    }


    public function drop($selectedOption)
    {

        $conn = $this->db->establishConnection();
        $sql = "SELECT username FROM users ";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){

            while ($row = mysqli_fetch_assoc($result)) {
         

               $name = $row['username'];
            $array[] = $name;

        }
        return $array; 


                 }


      
    }
    




    public function markTaskAsDone($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET is_done = IF(is_done = 0, 1, 0) WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }

    public function getTasks()
    {
        $conn = $this->db->establishConnection();
        $taskQuery = $conn->query("select * from tasks");
        // $tasks = $taskQuery->fetch_all(MYSQLI_ASSOC);

        $tasks = [];
        while ($row = $taskQuery->fetch_assoc()) {
            $tasks[] = $row;
        }

        return $tasks;
    }

    
}

?>
