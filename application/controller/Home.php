<?php
  
  use App\Credentials;

  class Home extends Framework {

    /**
     * Function to load landing page.
     */
    public function index() {
      session_start();

      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        $this->view("welcome");
      }
      else {
        $this->view("home");
      }
    }

    /**
     * Function to load dashboard page.
     */
    public function dashboard() {
      session_start();

      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        $this->model("UserDb");
        $credentials = new Credentials();
        $userDb = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        $musicList = $userDb->requestMusic();
        $_SESSION["musicList"] = $musicList;

        $this->redirect("welcome");
      }
      else {
        $this->view("login");
      }
    }

    /**
     * Function to load user profile page.
     */
    public function user() {
      session_start();

      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        $this->model("UserDb");
        $credentials = new Credentials();
        $userDb = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        $userId = $userDb->getUserId($_SESSION["email"]);
        $userMusic = $userDb->getUserMusic($userId);
        $userFavourite = $userDb->getFavourite($userId);
        $_SESSION["userMusic"] = $userMusic;
        $_SESSION["userfavourite"] = $userFavourite;
        $this->view("dashboard");
      }
      else {
        $this->view("login");
      }
    }

    /**
     * Function to load login page.
     */
    public function login() {
      session_start();

      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        $this->redirect("welcome");
      }
      else {
        if(isset($_POST["login"])) {
          $this->model("UserDb");
          $this->model("Signup");
          $credentials = new Credentials();
          $userDb = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
          $validateSignup = new Signup();
  
          $validateSignup->validateEmail($_POST["email"]);
          $validateSignup->validatePassword($_POST["password"]);
  
          if($validateSignup->emailErr == "" && $validateSignup->passwordErr == "") {
            if($userDb->checkLogin($_POST["email"], $_POST["password"])) {
              $userprofile = $userDb->fetchUserProfile($_POST["email"]);
              $musicList = $userDb->requestMusic();
              $userId = $userDb->getUserId($_POST["email"]);
              $userMusic = $userDb->getUserMusic($userId);
              $_SESSION["userprofile"] = $userprofile;
              $_SESSION["musicList"] = $musicList;
              $_SESSION["userMusic"] = $userMusic;
              $_SESSION["email"] = $_POST["email"];
              $_SESSION["userid"] = $userId;
              $_SESSION["username"] = $userDb->getUsername($_POST["email"]);
              $_SESSION["loggedIn"] = TRUE;
              $this->redirect("welcome");
            }
            else {
              echo '<script>alert("The username and password are incorrect.")</script>';
              $this->view("login");
            }
          }
          else {
            $GLOBALS["emailErr"] = $validateSignup->emailErr;
            $GLOBALS["passwordErr"] = $validateSignup->passwordErr;
            $this->view("login");
          }
        }
        else {
          $this->view("login");
        }
      }
    }
    
    /**
     * Function to load forget password page.
     */
    public function forget() {
      session_start();
      $_SESSION["mailSent"] = FALSE;

      if(isset($_POST["forgetpassword"])) {
        $this->model("UserDb");
        $this->model("Signup");
        $this->model("Email");

        $credentials = new Credentials();
        $userDb = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        $validateSignup = new Signup();
        $email = new Email();

        $validateSignup->validateEmail($_POST["email"]);

        if($validateSignup->emailErr == "") {
          if($userDb->checkUserNameExists($_POST["email"])) {
            if($email->sendEmail($_POST["email"])) {
              echo "<script>alert('E-mail has been sent!')</script>";
              $_SESSION["mailSent"] = TRUE;
              $this->view("login");
            }
            else {
              echo "<script>alert('E-mail could not be sent!')</script>";
              $this->view("forgetpassword");
            }
          }
          else {
            echo '<script>alert("User does not exist.")</script>';
            $this->view("forgetpassword");
          }
        }
        else {
          $GLOBALS["emailErr"] = $validateSignup->emailErr;
          $this->view("forgetpassword");
        }
      }
      else {
        $this->view("forgetpassword");
      }
    }

    /**
     * Function to load reset password page.
     */
    public function reset() {
      session_start();

      if(isset($_SESSION["mailSent"]) && $_SESSION["mailSent"]) {
        if(isset($_POST["resetpassword"])) {
          $this->model("UserDb");
          $this->model("Signup");

          $credentials = new Credentials();
          $userDb = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
          $validateSignup = new Signup();

          $validateSignup->validateEmail($_POST["email"]);
          $validateSignup->validatePassword($_POST["password"]);
          $validateSignup->matchPassword($_POST["password"], $_POST["cnfpassword"]);

          if($validateSignup->emailErr == "" && $validateSignup->passwordErr == "" && $validateSignup->cnfpasswordErr == "") {
            if($userDb->checkUserNameExists($_POST["email"])) {
              if($userDb->updateCredentials($_POST["email"], $_POST["password"])) {
                echo '<script>alert("Password changed successfully.")</script>';
                $_SESSION["mailSent"] = FALSE;
                $this->view("login");
              }
              else {
                echo '<script>alert("Error while updating password.")</script>';
                $this->view("resetpassword");
              }
            }
            else {
              echo '<script>alert("User does not exist.")</script>';
              $this->view("resetpassword");
            }
          }
          else {
            $GLOBALS["emailErr"] = $validateSignup->emailErr;
            $GLOBALS["passwordErr"] = $validateSignup->passwordErr;
            $GLOBALS["cnfpasswordErr"] = $validateSignup->cnfpasswordErr;
            $this->view("resetpassword");
          }
        }
        else {
          $this->view("resetpassword");
        }
      }
      else {
        $this->view("login");
      }
    }

    /**
     * Function to load signout page.
     */
    public function signout() {
      session_start();
      session_unset();
      session_destroy();
      $this->redirect("home");
    }

    public function page() {
      $this->error('error');
    }

  }
?>
