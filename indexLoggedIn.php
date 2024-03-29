<?php

session_start();

if(!isset($_SESSION['email'])){
    header("location:index.php");
}
else{
    $email=$_SESSION['email'];
    
    $xml=simplexml_load_file("UsersData.xml") or die("Error: Cannot create object");
    
    $firstName="";
    foreach ($xml->children() as $data){
        if($email == $data->email){
            $firstName = $data->firstName;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CaféBook</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

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
  
  <!-- =======================================================
  * Template Name: HeroBiz - v2.1.0
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v14.0" nonce="FzuMjXYX"></script>
    
    <div class="profileWrapper">
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top">
          <div class="container-fluid align-items-center d-flex justify-content-between">

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
        
        <!-- Upload - Page Cover -->
        <div id="uploadCover" onclick="hideUploadMenuLocal(), hideUploadMenuPublic()"></div>
        
        <!-- Local Cafe Upload -->
        <div id="boxLocal" class="uploadBoxWrapper">
            <div class="uploadBox d-flex justify-content-center">
                <button type="button" class="btn btn-close" onclick="hideUploadMenuLocal()" style="position: fixed; top:0; right:0;"></button>
                <form method="post" action="uploadCafe.php" enctype="multipart/form-data" class="d-flex justify-content-center flex-column">
                    <input type="hidden" name="upload_type" value="local">
                    <div class="form-group">
                        <label style="color:white;">Name</label>
                        <input class="form-control" type="text" name="cafe_name">
                    </div>
                    <div class="form-group">
                        <label style="color:white;">Location(search terms)</label>
                        <input class="form-control" type="text" name="cafe_location">
                    </div>
                    <div class="form-group">
                        <label style="color:white;">Description(max 1000 characters)</label>
                        <textarea class="form-control" name="cafe_description" rows="3" maxlength="1000" style="overflow:auto; resize: none;"></textarea>
                    </div>
                    <br/><br/>
                    <div class="form-group">
                        <label style="color:white;">Upload Photo</label>
                        <input class="form-control" type="file" name="image">
                    </div>
                    <br/>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn" style="color:white; background-color:darkgrey;">Upload</button>
                    </div>
                </form>
            </div>
        </div>
        
        <main id="main">
          <!-- ======= Blog Section ======= -->
          <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">   
                
              <div class="row g-5">

                <div class="col-lg-12">

                    <div class="row gy-4 posts-list">
                        <!-- Recommendations label -->
                        <div class="col-lg-12">
                            <article class="d-flex justify-content-center flex-column">
                                <h1 class="title">
                                Hello <?php echo $firstName; ?>. 
                                </h1>
                                <div class="d-flex justify-content align-self-end">
                                    <div class="read-more mt-auto">
                                        <button class="btn-add" onclick="showUploadMenuLocal()">Add Café</button>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- End recommendations label -->
                        
                        <!-- Cafes list -->
                        <div id="cafeList" class="row gy-4 posts-list"> 
                            
<!--                        while($row=mysqli_fetch_array($cafesResult)){-->
                            
                             
                            <?php
                                $xml2=simplexml_load_file("CafesData.xml") or die("Error: Cannot create object");
                                foreach ($xml2->children() as $data){
                                    $data->sessionEmail=$email;  
                                }      
                                $handle= fopen("CafesData.xml", "wb");
                                fwrite($handle, $xml2->asXML());
                                fclose($handle);
                                
                                
                                $xslDoc = new DOMDocument();
                                $xslDoc->load("CafesData.xsl");

                                $xmlDoc = new DOMDocument();
                                $xmlDoc->load("CafesData.xml");

                                $proc= new XSLTProcessor();
                                $proc->importStylesheet($xslDoc);
                                echo $proc->transformToXml($xmlDoc);
                            ?>   
                        
                        </div>
                        <!-- End Cafes list -->    
                        
                    </div>

                  </div>

                </div>

            </div>
              
            <!-- Delete Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure you want to delete this cafe?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                  </div>
                </div>
              </div>
            </div>  
            <!-- End Delete Modal -->
            
          </section><!-- End Blog Section -->
          
            
            
        </main><!-- End #main -->

        <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <div id="preloader"></div>

        
    </div>
    
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="footer-legal text-center">
        <div class="container d-flex justify-content-center">
            
            <div class="row">
              <div class="footer-info">
                <h3>CaféBook</h3>
                <p>
                  <strong>Author: </strong>Munteanu Teofil<br>
                  <strong>Email: </strong>andreiteofil01@gmail.com<br>
                </p>
              </div>
              <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10848.673779342269!2d27.5722978!3d47.1741385!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x95f1e37c73c23e74!2sAlexandru%20Ioan%20Cuza%20University%20of%20Ia%C8%99i!5e0!3m2!1sen!2sro!4v1655924747803!5m2!1sen!2sro" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
        </div>
      </div>  
    </footer>
    <!-- End Footer -->
    
    
    
    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/mediaScripts.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>