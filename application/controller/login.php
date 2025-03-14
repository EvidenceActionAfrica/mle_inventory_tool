<?php

class Login extends Controller
{
   
    public function index(){
        if (isset($_GET['error'])) {
            $invalid_credentials = '<div class="error-msg"> Invalid email or password </div>';
        }
        require APP . 'view/login/index.php';
    }
   

    public function loginUser(){
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        echo "loginUser method reached!"; 
        session_start();
        $staff = $this->model->getStaff($_POST["inputEmailAddress"]);
        
        if ($staff != null) {
            $saved_password = $staff->password;
            $_SESSION['user_email'] = $staff->email;
            $_SESSION['role'] = $staff->role;
            $_SESSION['department'] = json_decode($staff->department, true);
            $_SESSION['position'] = $staff->position;

            $is_correct_user = password_verify($_POST["inputPassword"], $saved_password);
    
            if ($is_correct_user) {
                $user_email = $_POST["inputEmailAddress"];

                if ($user_email) {
                    $parts = explode('@', $user_email); // Split email at '@'
                    $user_name = $parts[0]; // Get the first part of the email that contains the user's name
        
                    if (strpos($user_name, '.') !== false) {
                        $nameParts = explode('.', $user_name);
                        $user_name = $nameParts[0]; // Get the first name
                    }
        
                    $_SESSION['user'] = ucfirst($user_name); // Captalize first letter and set user in session variable
                }

                //TODO: Add role definitions so that you are directed to different places based on role
                // if($_SESSION['role'] == "DE"){
                //     //Proceed to DE interface
                //     header('Location:' . URL . 'submissions_DE/index/');
                //     exit();
                // } else {
                //     // Proceed to index page
                //     //$this->model->update_login($_POST["inputEmailAddress"]);
                //     header('Location:' . URL . 'login/index/');
                //     exit();
                // } 
                header('Location:' . URL . 'home/index/');
                exit();
            } else {
                // Password verification failed
                header('Location:' . URL . 'login/index?error=invalid_credentials');
                exit();
            }
        } else {
            // Staff not found
            header('Location:' . URL . 'login/index?error=invalid_credentials');
            exit(); 
        }
        
    }
    
    public function password_reset() {
        session_start();

        if (isset($_GET['error'])) {
            $invalid_credentials = '<div class="error-msg"> An error occured, please try again.</div>';
        } elseif (isset($_GET['success'])) {
            $successful_login = '<div class="success-msg"> Password reset successfully. Taking you back to login page...</div>';
            // Redirect after displaying success message.
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "' . URL . 'login/index/";
                    }, 1700); 
                  </script>';

        } elseif (isset($_GET['null'])) {
            $null_result = '<div class="error-msg"> No user found with the given email address.</div>';
        }
        require APP . 'view/login/forgot_password.php';
    }

 
    public function submit_password_reset() {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['inputEmailAddress'];
            $newPassword1 = $_POST['newPassword1'];

            $hashed_password = password_hash($newPassword1, PASSWORD_DEFAULT); 
            // Call model function to reset password
            $update_query = $this->model->reset_password($email, $hashed_password);

            if ($update_query) {
                header('Location:' . URL . 'login/password_reset?success');
            } else {
                header('Location:' . URL . 'login/password_reset?null');
            }

        } else {
            // redirect the user back to the sign in page upon failed validation to try again
            header('Location:' . URL . 'login/password_reset?error=invalid_credentials');
        }

    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header('Location:' . URL . 'login/index/');
    }
}