<?php
use framework\helpers\Html;
?>
<!DOCTYPE HTML>
<html lag="fa">
       <head>
              <!-- Set Charset -->
              <meta charset="UTF-8">

              <!-- Page Title -->
              <title><?php echo Html::escape($this->title);?></title>

              <!-- Favicon -->
              <link rel="shortcut icon" href="<?php echo $this->getThemeUrl('img/favicon.ico');?>">

              <!-- Stylesheets -->
              <link rel="stylesheet" href="<?php echo $this->getThemeUrl('css/bootstrap.min.css');?>">
              <link rel="stylesheet" href="<?php echo $this->getThemeUrl('css/style.css');?>">

              <!-- Javascripts -->
              <script type="text/javascript" src="<?php echo $this->getThemeUrl('js/jquery.min.js');?>"></script>
              <script type="text/javascript" src="<?php echo $this->getThemeUrl('js/bootstrap.min.js');?>"></script>
       </head>
       <body>
              <header id="header">
                     <div class="nav navbar-inverse">
                            <div class="container">
                                   <div class="navbar navbar-header">
                                          <button class="navbar-toggle" data-toggle="collapse" data-target="#topMenuCollapse">
                                                 <span class="icon-bar"></span>
                                                 <span class="icon-bar"></span>
                                                 <span class="icon-bar"></span>
                                          </button>
                                          <a href="" class="navbar-brand">Payment <sub>Create Unlimited Payment Form</sub></a>
                                   </div>
                                   <div class="collapse navbar-collapse" id="topMenuCollapse">
                                          <nav id="topMenu">
                                                 <ul class="nav navbar-nav">
                                                        <li><a href="<?php echo Framework::getSiteUrl();?>">صفحه نخست</a></li>
                                                        <li><a href="<?php echo Framework::createUrl('request/contact');?>">تماس با ما</a></li>
                                                        <li><a href="<?php echo Framework::getSiteUrl();?>">پشتیبانی آنلاین</a></li>
                                                 </ul>
                                          </nav>
                                   </div>
                            </div>
                     </div>
              </header>
              <?php echo $content;?>
              <footer id="footer">
                     <p>Created And Designed By <a target="_blank" href="http://www.TPHP.ir">TPHP</a> All Rights Reserved</p>
              </footer>
       </body>
</html>