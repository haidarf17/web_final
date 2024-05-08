<?php
class RegisterUser
{
    private $un;
    private $email;
    private $fn;
    private $dob;
    private $gender;
    private $raw_password;
    private $encrypted_password;
    public $error;
    public $success;
    private $conn;

    public function __construct($conn, $fn, $email, $dob, $un, $pass, $gender)
    {
        $this->conn = $conn;
        $this->un = filter_var(trim($un), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->fn = filter_var(trim($fn), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->gender = filter_var(trim($gender), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->dob = $dob;
        $this->raw_password = filter_var(trim($pass), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        if ($this->validateFields()) {
            $this->registerUser();
        }
    }

    private function validateFields()
    {
        if (empty($this->un) || empty($this->raw_password) || empty($this->fn) || empty($this->email) || empty($this->dob) || empty($this->gender)) {
            $this->error = "All fields are required.";
            return false;
        }
        return true;
    }

    private function unExists()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE un = ?");
        $stmt->bind_param("s", $this->un);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    private function registerUser()
    {
        if (!$this->unExists()) {
            $stmt = $this->conn->prepare("INSERT INTO users (fn, email, dob, un, pass, gender) VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("ssssss", $this->fn, $this->email, $this->dob, $this->un, $this->encrypted_password, $this->gender);
            if ($stmt->execute()) {
                $stmt->close();
                $this->success = "Registration successful. Redirecting to login...";
                header("Location: ../client/signin.php");
                exit();
            } else {
                $this->error = "Something went wrong, please try again.";
            }
            $stmt->close();
        } else {
            $this->error = "un already taken, please choose a different one.";
        }
    }
}
