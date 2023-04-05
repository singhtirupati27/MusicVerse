<?php

  use App\Credentials;
  
  class Register extends Framework {
    
    /**
     * Function to load user registration page.
     */
    public function signup() {
      if(isset($_POST["register"])) {
        $this->model("Signup");
        $this->model("UserDb");
        $this->model("Email");

        $credentials = new Credentials();
        $userDb = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        $emailVerify = new Email();
        $validateSignup = new Signup();

        $registerOk = $validateSignup->checkRegistration($_POST);
        // $emailVerify->verifyEmail($_POST["email"]);

        if($registerOk) {
          if($emailVerify->emailErr == "") {
            if(!$userDb->checkUserNameExists($_POST["email"]) && !$userDb->checkUserContactExists($_POST["phone"])) {
              if($userDb->registerUser($_POST)) {
                echo "<script>alert('Your account has been created successfully!')</script>";
                $this->view("login");
              }
              else {
                echo "<script>alert('Error while creating your account. Please try again.')</script>";
                $this->view("register");
              }
            }
            else {
              echo "<script>alert('User already exists.')</script>";
              $this->view("register");
            }
          }
          else {
            echo "<script>alert('Invalid email!')</script>";
            $this->view("register");
          }
        }
        else {
          $GLOBALS["nameErr"] = $validateSignup->nameErr;
          $GLOBALS["genderErr"] = $validateSignup->genderErr;
          $GLOBALS["interestErr"] = $validateSignup->interestErr;
          $GLOBALS["phoneErr"] = $validateSignup->phoneErr;
          $GLOBALS["emailErr"] = $validateSignup->emailErr;
          $GLOBALS["passwordErr"] = $validateSignup->passwordErr;
          $GLOBALS["cnfpasswordErr"] = $validateSignup->cnfpasswordErr;
          $this->view("register");
        }
      }
      else {
        $this->view("register");
      }
    }

  }
?>
