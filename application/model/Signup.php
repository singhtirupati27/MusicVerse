<?php

  /**
   * This class will hold all validation methods and 
   * their error messages.
   */
  class Signup {
    public string $nameErr = "";
    public string $genderErr = "";
    public string $interestErr = "";
    public string $phoneErr = "";
    public string $emailErr = "";
    public string $passwordErr = "";
    public string $cnfpasswordErr = "";

    /**
     * Function to validate full name.
     * 
     *  @param string $name
     *    Holds full name of user.
     * 
     *  @return bool
     *    True if format valid, false if not.
     */
    public function validateName($name) {
      if(empty($name)) {
        $this->nameErr = "Name field cannot be empty.";
        return FALSE;
      }
      elseif(!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
        $this->nameErr = "Only characters are allowed!";
        return FALSE;
      }
      else {
        return TRUE;
      }
    }

    /**
     * Function to check gender value.
     * 
     *  @param string gender
     *    Contains gender value.
     */
    public function validateGender($gender) {
      if(empty($gender)) {
        $this->genderErr = "Gender is required";
      }
      else {
        $this->genderErr = "";
      }
    }

    /**
     * Function to check whether field contains one value or not.
     * 
     *  @param array $interest
     *    Hold interest values.
     */
    public function validateInterest($interest) {
      if(empty($interest)) {
        $this->interestErr = "Please select at least 1 genre";
      }
      else {
        $this->interestErr = "";
      }
    }

    /**
     * Function to validate phone number format.
     * 
     *  @param string $phone
     *    Contains phone number.
     * 
     *  @return bool
     *   Return true if format valid, false if not.
     */
    public function validateContact($phone) {
      if(empty($phone)) {
        $this->phoneErr = "Phone number is required";
        return FALSE;
      }
      elseif(!preg_match("/^(\+91)[0-9]{10}$/", $phone)) {
        $this->phoneErr = "Invalid phone number!";
        return FALSE;
      }
      else {
        return TRUE;
      }
    }

    /**
     * Function to check email format.
     * 
     *  @param string $email
     *    Contains email address.
     */
    public function validateEmail($email) {
      if(empty($email)) {
        $this->emailErr = "Email is required";
      }
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->emailErr = "Invalid email format!";
      }
      else {
        $this->emailErr = "";
      }
    }

    /**
     * Function to check password pattern.
     *  
     *  @param string $password
     *    Contains password entered by user.
     */
    public function validatePassword($password) {
      $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/";

      if(empty($password)) {
        $this->passwordErr = "Password cannot be empty.";
      }
      elseif (!strlen($password) >= 8 && strlen($password) <= 15) {
        $this->passwordErr = "Password length must be greater than 8 characters.";
      }
      elseif(!preg_match($pattern, $password)) {
        $this->passwordErr = "Password must contain at least one lower, one upper, one numeric and one special character";
      }
      else {
        $this->passwordErr = "";
      }
    }

    /**
     * Function to match password and confirm password.
     * 
     *  @param string $password
     *    Contains user password.
     * 
     *  @param string $cnfpassword
     *    Contains user confirm password.
     * 
     *  @return bool
     *    True if password match, false if not.
     */
    public function matchPassword($password, $cnfpassword) {
      if(empty($cnfpassword)) {
        $this->cnfpasswordErr = "Confirm password cannot be empty";
        return FALSE;
      }
      elseif($password != $cnfpassword) {
        $this->cnfpasswordErr = "Password do not match.";
        return FALSE;
      }
      else {
        return TRUE;
      }
    }

  }
?>
