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
                <!-- Vendor CSS Files -->
                <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
                <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"/>
                <link href="assets/vendor/aos/aos.css" rel="stylesheet"/>
                <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet"/>
                <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"/>

                <!-- Variables CSS Files. Uncomment your preferred color scheme -->
                <link href="assets/css1/variables-orange.css" rel="stylesheet"/>

                <!-- Template Main CSS File -->
                <link href="assets/css1/mainstyle7.css" rel="stylesheet"/>
            </head>
            <body>
                <xsl:for-each select="root/cafe">
                    <div class="col-lg-6">
                        <article class="d-flex flex-column">

                          <div class="row">
                              <div class="col">
                                <h2 class="title">
                                    <a href="cafe_details.php?name={name}&amp;email={emailAssigned}">
                                        <span>
                                          <xsl:value-of select="name"/>
                                        </span>
                                    </a>
                                </h2>
                              </div>
                              
                            <div class="col">
                                <xsl:if test="sessionEmail = emailAssigned">
                                 <xsl:element name="button">
                                    <xsl:attribute name="type">button</xsl:attribute>
                                    <xsl:attribute name="onclick">
                                        <xsl:text>selectDelete('</xsl:text>
                                        <xsl:value-of select="name" />
                                        <xsl:text>')</xsl:text>
                                    </xsl:attribute>
                                    <xsl:attribute name="class">btn btn-danger float-end</xsl:attribute>
                                    <xsl:attribute name="data-toggle">modal</xsl:attribute>
                                    <xsl:attribute name="data-target">#exampleModalCenter</xsl:attribute>
                                    X
                                  </xsl:element>
                                </xsl:if>
                              </div>
                          </div>

                          <div class="meta-top">
                            <ul>
                              <li class="d-flex align-items-center"><i class="bi bi-person"></i>Post by: <xsl:value-of select="emailAssigned"/></li>
                            </ul>
                          </div>  

                          <div class="content">
                            <p>
                              <xsl:value-of select="description"/>
                            </p>
                          </div>
                          
                          
                          <div class="read-more mt-auto align-self-end">
                              <xsl:element name="a">
                                 <xsl:attribute name="href">
                                     <xsl:value-of select="concat('cafe_details.php?name=', name, '&amp;email=', emailAssigned)"/>
                                 </xsl:attribute>
                                 <span>Details </span>
                             </xsl:element>
                            
                          </div>

                        </article>
                      </div>
                </xsl:for-each>   
                
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
    </xsl:template>

</xsl:stylesheet>
