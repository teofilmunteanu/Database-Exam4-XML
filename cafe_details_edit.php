<?php
session_start();

if(!isset($_SESSION['email']) || $_SESSION['email'] != $_GET['email']){
    header("location:index.php");
}
else
{
    $email = $_GET['email'];
    $cafeName = $_GET['name'];

    $resultCafe = "";
     
    $xml=simplexml_load_file("CafesData.xml") or die("Error: Cannot create object");

    foreach ($xml->children() as $data){
        if($data->name == $cafeName && $data->emailAssigned == $email){
            $resultCafe = $data;
            break;
        }
    }
        
    $msg="";
    
    if (isset($_POST['update'])) {
        $msg="Saved";
        
        $newCafeName = $_POST['name'];
        $newLocation = $_POST['location'];
        $newDescription = $_POST['description'];
        
        
        if($newCafeName=="" || $newLocation=="" || $newDescription==""){
            $msg="All fields are mandatory!";
        }
        else{
            if(isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE){
                $target="./images/".basename($_FILES['image']['name']);

                if (!file_exists('./images/')) {
                    mkdir('./images', 0777, true);
                }

                if(! move_uploaded_file($_FILES['image']['tmp_name'],$target)){
                    $msg="File not saved!";
                }
                else{
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimetype = finfo_file($finfo, $target);
                    $fileTypes = array("jpg", "jpeg", "png", "gif");
                    $ok = false;
                    foreach($fileTypes as $ft){
                        if($mimetype == 'image/'.$ft){
                            $ok = true;
                        }
                    }
                    if(! $ok){
                        $msg="Invalid file format!";
                    }
                } 
            }else{
                $target=$resultCafe->image;
                move_uploaded_file($_FILES['image']['tmp_name'],$target);
            }  
            
            
        }
        

        if($msg == "Saved"){
            $resultCafe->name=$newCafeName;
            $resultCafe->location=$newLocation;
            $resultCafe->description=$newDescription;
            $resultCafe->image=$target;            
            $resultCafe->emailAssigned=$email;   
   
            $handle= fopen("CafesData.xml", "wb");
            fwrite($handle, $xml->asXML());
            fclose($handle);
            $msg="";
            
            header('Location:cafe_details.php?name='.$newCafeName.'&email='.$email);
        }
        

        
    } else if (isset($_POST['discard'])) {
    echo "oops";
//header('Location:cafe_details.php?name='.$cafeName.'&email='.$email);
    }
}

?>

<html>
    <head>
        <title>Profile</title> 
        
        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
        
        <!-- Variables CSS Files. Uncomment your preferred color scheme -->
        <link href="assets/css1/variables-orange.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="assets/css1/mainstyle7.css" rel="stylesheet">
        
        <link href="assets/css1/mystyles2.css" rel="stylesheet">
    </head>
    
    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top" data-scrollto-offset="0">
          <div class="container-fluid d-flex align-items-center justify-content-between">

            <div class="row">
                <div class="col">
                    <h1><a href = "index.php" onclick="saveAudioTime()">CaféBook</a><span>.</span></h1>
                </div>
                <div class="col">
                    <div class="row">
                        <?php
                        $xml = simplexml_load_file('cafeSmoke.xml');

                        $svg = $xml->svg->asXML();
                        $svg = str_replace('<?xml version="1.0"?>', '', $svg);

                        $html = '<div>' . $svg . '</div>';

                        echo $html;
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $xml = simplexml_load_file('cafeCup.xml');

                        $svg = $xml->svg->asXML();
                        $svg = str_replace('<?xml version="1.0"?>', '', $svg);

                        $html = '<div>' . $svg . '</div>';

                        echo $html;
                        ?>
                    </div>
                </div>
                
            </div>

            <nav id="navbar" class="navbar">
              <ul>
                  <li><a class="active" href="index.php" onclick="saveAudioTime()">Coffee Shops</a></li>
              </ul>
              <i class="bi bi-list mobile-nav-toggle d-none"></i>
            </nav>
              
            <div>
              <a class="btn-getstarted" href="logout.php">Log Out</a>
            </div>
          </div>
        </header>
        <!-- End Header -->
        
        
        <!-- Music Controller -->
        <audio id="music" autoplay loop>
            <source src="assets/audio/Ichika_Nito_Felling.mp3" type="audio/mpeg">
        </audio>
        
        <div id="musicOptions">
            <button class="btn" onclick="toggleMusicOptions()"><i class="bi bi-music-note-beamed"></i></button>
        </div>
        
        <div id="musicController">
            <input type="range" orient="vertical"  min="0" max="1" step="0.1" id="volume" onchange="setVolume(this.value);"> 
        </div>
        <!-- End Music Controller -->
        
        
        <main id="main">

          <!-- ======= Blog Section ======= -->
          <section id="blog" class="blog">
            <?php
                if($resultCafe){
            ?>
            <div class="container" data-aos="fade-up">

              <div class="row g-5">

                <div class="col-lg-12">        
                  <div class="row gy-4 posts-list"> 

                    <div class="col-lg-12">
                      <article>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="container">
                                <div class="row">
                                  <div class="col">
                                    <h1>
                                        <input type="text" name="name" value="<?php echo $resultCafe->name;?>" style="color:#485664">
                                    </h1>
                                    
                                    <h4>Description:</h4>
                                    <textarea name="description" rows="5" cols="50" style="resize:none;"><?php echo $resultCafe->description;?></textarea>

                                    <div>
                                      <h4>Location:</h4>
                                      <input type="text" name="location" value="<?php echo $resultCafe->location;?>">

                                      <!-- SOURCE: https://www.embedgooglemap.net Exemplu q=palatul%20culturii%20iasi-->
                                      <div class="mapouter">
                                          <?php 
                                          $searchItem = $resultCafe->location;
                                          $searchItem = str_replace(" ","%20", $searchItem);
                                          ?>
                                          <div class="gmap_canvas">
                                              <iframe width="500" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $searchItem; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                              <style>.mapouter{position:relative;text-align:right;height:500px;width:500px;}</style>
                                              <style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:500px;}</style>
                                          </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col">
                                    <div class="row d-flex justify-content-center">
                                       
                                            <label>Upload Photo</label>
                                            <input class="form-control" type="file" name="image">
                                        
                                        <br/>
                                        <p><?php echo $msg; ?></p>
                                    </div>
                                    <br/><br/>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-2">
                                            <input type="submit" class="btn-add" name="update" value="Update" onclick="saveAudioTime()">
                                            <br><br>
                                            <input type="submit" class="btn-add" name="discard" value="Discard" onclick="saveAudioTime()">
                                        </div> 
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </form>  
                          
                      </article>

                    </div><!-- End post list item -->

                  </div>

                </div>

              </div>

            </div>
            <?php
                }
                else{
            ?>        

                <div class="wrapper">
                    <div id="formContent">
                        <?php 
                            echo "No cafe found!";
                        ?>
                        <br/>
                        <a type="button" class="btn btn-primary" href='index.php'>Back</a>
                    </div>
                </div>

            <?php
                }
            ?>
          </section><!-- End Blog Section -->

        </main><!-- End main -->
        
        <!-- Vendor JS Files -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        
        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
        <script src="assets/js/mediaScripts.js"></script>
    </body>
</html>
