<?php
session_start();

if(!isset($_SESSION['email'])){
    header("location:index.php");
}
else
{
    $currentUser = $_SESSION['email'];

    $email = $_GET['email'];
    $cafeName = $_GET['name'];
//    $cafesSql="SELECT * FROM cafes WHERE name='$cafeName' AND emailAssigned='$email';";
//    $cafesResult=mysqli_query($con, $cafesSql)or die(mysqli_error($con));
//    $row=mysqli_fetch_array($cafesResult);
    
    $xml=simplexml_load_file("CafesData.xml") or die("Error: Cannot create object");

    $cafesResult = "";
    foreach ($xml->children() as $data){
        if($data->name == $cafeName && $data->emailAssigned == $email){
            $cafesResult = $data;
            break;
        }
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
                if($cafesResult){
            ?>
            
            <div class="container" data-aos="fade-up">

              <div class="row g-5">

                <div class="col-lg-12">        
                  <div class="row gy-4 posts-list"> 

                    <div class="col-lg-12">
                      <article>
                        <div class="container">
                            <div class="row">
                              <div class="col">
                                <h1 style="color:#485664">
                                    <?php echo $cafesResult->name;?>
                                </h1>
                                <h4>Description:</h4>
                                <p>
                                  <?php echo $cafesResult->description; ?>
                                </p>
                                
                                <div>
                                  <h4>Location:</h4>
                                  <?php echo $cafesResult->location; ?>
                                  
                                  <!-- SOURCE: https://www.embedgooglemap.net Exemplu q=palatul%20culturii%20iasi-->
                                  <div class="mapouter">
                                      <?php 
                                      $searchItem = $cafesResult->location;
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
                                  <img src ="<?php echo $cafesResult->image; ?>" style='float:right; height: 70%; width: 70%;'>
                                </div>
                                <br/><br/>
                                
                                <?php if($currentUser == $email) {?>
                                <div class="row row d-flex justify-content-center">
                                    <div class="col-lg-2">
                                        <a class="btn-add" href="cafe_details_edit.php?name=<?php echo $cafesResult->name;?>&email=<?php echo $cafesResult->emailAssigned;?>" style="color:white;" onclick="saveAudioTime()">Edit</a>
                                    </div> 
                                </div>
                                <?php } ?>
                              </div>
                            </div>
                        </div>
                          
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
