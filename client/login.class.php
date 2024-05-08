<?php
class LoginUser
{
    private $conn;
    private $un;
    private $pass;
    public $error;
    public $success;

    public function __construct($conn, $un, $pass)
    {
        $this->un = $un;
        $this->pass = $pass;
        $this->conn = $conn;
        $this->login();
    }

    private function login()
    {
        $stmt = $this->conn->prepare("SELECT un, pass FROM users WHERE un = ?");
        if ($stmt === false) {
            $this->error = "Database error: Unable to prepare statement";
            return;
        }

        $stmt->bind_param("s", $this->un);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($this->pass, $user['pass'])) {
                session_start();
                $_SESSION['user'] = $this->un;
                header("Location: ../admin/index.php");
                exit();
            } else {
                $this->error = "Wrong password";
            }
        } else {
            $this->error = "Incorrect username or password";
        }

        $stmt->close();
    }
}
