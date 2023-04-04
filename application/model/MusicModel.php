<?php

  class MusicModel {
    public $uploadOk = 1;
    public $uploadErr = "";
    public $uploadImgErr = "";
    public $target_dir = "public/music/usermusic/";
    public $musicFileLocation = "";
    public $musicFileType;
    public $imgUploadErr = "";
    public $img_target_dir = "public/music/coverimage/";
    public $imageFileLocation = "";
    public $imageFileType;
    
    /**
     * Function to upload music file.
     * 
     *  @param string $musicFile
     *    Contains music file path.
     */
    public function uploadMusic($musicFile) {
      $this->musicFileLocation = $this->target_dir . basename($musicFile["name"]);

      $this->musicFileType = strtolower(pathinfo($this->musicFileLocation, PATHINFO_EXTENSION));
      
      if(!$musicFile["size"] == 0) {
        if($musicFile["size"] > 10000000) {
          $this->uploadErr = "Sorry, music file is too large.";
          $this->uploadOk = 0;
        }
  
        if($this->musicFileType != "mp3" && $this->musicFileType != "wav" && $this->musicFileType != "ogg") {
          $this->uploadErr = "Sorry, only MP3, WAV and OGG music file allowed.";
          $this->uploadOk = 0;
        }
      }
      else {
        $this->uploadErr = "Please select a music file.";
        $this->uploadOk = 0;
      }
    }

    /**
     * Function to upload cover image.
     * 
     *  @param string $musicCover
     *    Holds image path value.
     */
    public function uploadCoverImage($musicCover) {
      $this->imageFileLocation = $this->img_target_dir . basename($musicCover["name"]);

      $this->imageFileType = strtolower(pathinfo($this->imageFileLocation, PATHINFO_EXTENSION));

      if(!$musicCover["size"] == 0) {  
        if($musicCover["size"] > 10000000) {
          $this->uploadImgErr = "Sorry, image file is too large.";
          $this->uploadOk = 0;
        }
  
        if($this->imageFileType != "jpg" && $this->imageFileType != "png" && $this->imageFileType != "jpeg" && $this->imageFileType != "gif") {
          $this->uploadImgErr = "Sorry, only JPG, PNG, JPEG and GIF file allowed.";
          $this->uploadOk = 0;
        }
      }
      else {
        $this->uploadImgErr = "Please select a cover image file.";
      }
    }

    /**
     * Function check wether input field is empty or not.
     * 
     *  @param string $name
     *    Holds field value.
     * 
     *  @return string
     */
    public function isEmpty($name) {
      if(empty($name)) {
        $this->uploadOk = 0;
        $msg = "Field cannot be empty";
        return $msg;
      }
      else {
        $msg = "";
        return $msg;
      }
    }

  }
?>
