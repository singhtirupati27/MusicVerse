<?php
  session_start();

  use App\Credentials;

  /**
   * Music controller class to upload, play and add to favourite music.
   */
  class Music extends Framework {

    /**
     * Function to load user music upload page.
     */
    public function upload() {
      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        if(isset($_POST["add-music"])) {
          $this->model("MusicModel");
          $this->model("UserDb");
        
          $music = new MusicModel();
          $credentials = new Credentials();
          $database = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        
          $userId = $database->getUserId($_SESSION["email"]);
          $music->uploadMusic($_FILES["music-file"]);

          $_SESSION["userId"] = $userId;
          $GLOBALS["mnameErr"] = $music->isEmpty($_POST["music-name"]);
          $GLOBALS["singerErr"] = $music->isEmpty($_POST["singer"]);

          // Check if music cover image is not empty.
          if(!empty($_FILES["cover-image"])) {
            $music->uploadCoverImage($_FILES["cover-image"]);
          }
          else {
            $music->imageFileLocation = "";
          }
        
          // Check of uploaded music input field is ok.
          if($music->uploadOk == 1) {
            $userMusicExists = $database->isMusicExists($userId, $_POST["music-name"], $_POST["singer"]);
            $musicExists = $database->isMusicExists("", $_POST["music-name"], $_POST["singer"]);

            // Check if music being uploaded already exists.
            if(!$userMusicExists && !$musicExists){
              $addUserMusic = $database->addUserMusic($userId, $_POST["music-name"], $_POST["singer"], $_POST["genre"], 
                $music->musicFileLocation, $music->imageFileLocation);

              $uploadId = $database->fetchMusicById($_POST["music-name"], $_POST["singer"]);

              $addMusic = $database->addMusic($_POST["music-name"], $_POST["singer"], $_POST["genre"], 
                $music->musicFileLocation, $music->imageFileLocation, $uploadId);

              // Check for whether music has been uploaded or not.
              if($addUserMusic && $addMusic) {
                if(move_uploaded_file($_FILES["music-file"]["tmp_name"], $music->musicFileLocation)) {

                  if(!empty($_FILES["cover-image"])) {
                    move_uploaded_file($_FILES["cover-image"]["tmp_name"], $music->imageFileLocation);
                  }
                  echo "<script>alert('Music uploaded successfully!')</script>";
                  $this->view("addmusic");
                }
                else {
                  echo "<script>alert('Error occured while uploading!')</script>";
                  $this->view("addmusic");
                }
              }
              else {
                echo "<script>alert('Failed to upload music!')</script>";
                $this->view("addmusic");
              }
            }
            else {
              echo "<script>alert('Music already exists!')</script>";
              $this->view("addmusic");
            }
          }
          else {
            $GLOBALS["musicErr"] = $music->uploadErr;
            $GLOBALS["musicImgErr"] = $music->uploadImgErr;
            $this->view("addmusic");
          }
        }
        else {
          $this->view("addmusic");
        }
      }
      else {
        $this->redirect("home");
      }
    }

    /**
     * Function to load play music page.
     * 
     *  @param int $musicId
     *    Hold current playing music id.
     */
    public function play(int $musicId) {
      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == TRUE) {
        $this->model("UserDb");

        $credentials = new Credentials();
        $database = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        $isFav = $database->isFavourite($_SESSION["userid"], $musicId);
        $music = $database->requestMusic();

        $_SESSION["isFav"] = $isFav;
        $_SESSION["playnow"] = $music[$musicId - 1];

        $this->view("playmusic");
      }
      else {
        $this->redirect("home");
      }
    }

    /**
     * Function load music page with load more button.
     */
    public function loadMore() {
      $this->model("UserDb");
      $credentials = new Credentials();
      $database = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
      $music = $database->musicList();
      $rowCount = $database->calculateRows("music");

      $_SESSION["loadmusic"] = $music;
      $_SESSION["rowCount"] = $rowCount;     

      return ($this->view("music"));
    }

    /**
     * Function to load add or remove to favourite page.
     */
    public function favourites() {
      $this->model("UserDb");

      $credentials = new Credentials();
      $database = new UserDb($_ENV['DBNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);

      $fav = $database->favourite($_SESSION["userid"], $_SESSION["currentMusicId"]);

      echo $fav;
    }

  }
?>
