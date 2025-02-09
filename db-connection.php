<?php
class Database {
    private $host = 'localhost'; // Update with your database host
    private $user = 'root'; // Your database username
    private $password = ''; // Your database password
    private $dbname = 'your_database'; // Your database name

    public $conn;

    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Sanitize input to prevent SQL injection
    public function sanitize($input) {
        return $this->conn->real_escape_string($input);
    }
}
?>
