<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : CafesData.xsl
    Created on : May 26, 2023, 8:45 AM
    Author     : andre
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules 
         syntax recommendation http://www.w3.org/TR/xslt 
    -->
    <xsl:template match="/">
        <html>
            <head>
                <!-- Favicons -->
                <link href="assets/img/favicon.png" rel="icon">
                <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
            </head>
            <body>
                <xsl:for-each select="root/cafes">
                    <div class="col-lg-6">
                        <article class="d-flex flex-column">

                          <div class="row">
                              <div class="col">
                                <h2 class="title">
                                    <a href="cafe_details.php?name={name}&amp;email={email}" onclick="{saveAudioTime()}">
                                        <xsl:value-of select="name"/>                                        
                                        <xsl:value-of select="emailAssigned"/>
                                        <span>
                                          <xsl:value-of select="name"/>
                                        </span>
                                    </a>
                                </h2>
                              </div>

                              <?php if($cafeDoc->emailAssigned==$_SESSION['email']){ ?>
                              <div class="col">
                                <button type="button" id="<?php echo $cafeDoc->_id;?>" onclick="selectDelete(this.id)" class="btn btn-danger float-end" data-toggle="modal" data-target="#exampleModalCenter">
                                  X
                                </button>
                              </div>
                              <?php }?>

                          </div>

                          <div class="meta-top">
                            <ul>
                              <li class="d-flex align-items-center"><i class="bi bi-person"></i>Post by: <?php echo $cafeDoc->emailAssigned; ?></li>
                            </ul>
                          </div>  

                          <div class="content">
                            <p>
                              <?php echo $cafeDoc->description; ?>
                            </p>
                          </div>

                          <div class="read-more mt-auto align-self-end">
                            <a href="cafe_details.php?name=<?php echo $cafeDoc->name;?>&email=<?php echo $cafeDoc->emailAssigned;?>" onclick="saveAudioTime()">Details</a>
                          </div>

                        </article>
                      </div>
                </xsl:for-each>   
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
