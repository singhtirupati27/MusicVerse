<?php
  session_start();

  use App\Credentials;

  /**
   * Profile controller class to update user profile.
   */
  class Profile extends Framework {

    /**
     * Function load user profile update page.
     */
    public function update() {
      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        $this->model("UserDb");

        $credentials = new Credentials();
        $database = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        
        $data = $database->fetchUserProfile($_SESSION["email"]);

        $_SESSION["email"] = $data[0]["user_email"];
        $_SESSION["userphone"] = $data[0]["user_phone"];

        if(isset($_POST["update-profile"])) {
          $this->model("Email");
          $this->model("Signup");

          $validateData = new Signup();
          $email = new Email();
        
          $validateData->validateEmail($_POST["email"]);
          $validateData->validateContact($_POST["phone"]);
          $validateData->validateInterest($_POST);
          // Disabled email verification using api as it taking time to receive response.
          // $email->verifyEmail($_POST["email"]);

          // Check if input fields are in valid format or not.
          if($validateData->emailErr == "" && $validateData->phoneErr == "" && $validateData->interestErr == "") {

            // Verify whether email is working or not.
            if($email->emailErr == "") {

              // Check whether if profile has been updated in database or not.
              if($database->updateProfile($_SESSION["email"], $_POST["email"], $_POST["phone"], $_POST["genre"])) {
                echo "<script>alert('Profile updated successfully!')</script>";
                $this->view("profileupdate");
              }
              else {
                echo "<script>alert('Unable to update your profile!')</script>";
                $this->view("profileupdate");
              }
            }
            else {
              echo "<script>alert('Invalid email')</script>";
              $this->view("profileupdate");
            }
          }
          else {
            $GLOBALS["interestErr"] = $validateData->interestErr;
            $GLOBALS["phoneErr"] = $validateData->phoneErr;
            $GLOBALS["emailErr"] = $validateData->emailErr;
            $this->view("profileupdate");
          }
        }
        else {
          $this->view("profileupdate");
        }
      }
      else {
        $this->view("login");
      }
    }

  }
?>
