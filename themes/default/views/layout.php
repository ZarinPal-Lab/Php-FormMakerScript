<?php
use framework\helpers\Html;
?>
<!DOCTYPE HTML>
<html>
      <head>
            <meta charset="UTF-8">
            <title><?php echo Html::escape($this->title);?></title>
            <meta name="viewport" content="width=device-width,initial-scale=1.0">
	     <link rel="shortcut icon" href="<?php echo $this->getThemeUrl('img/favicon.ico');?>">
            <link rel="stylesheet" href="<?php echo $this->getThemeUrl('css/bootstrap.min.css');?>">
            <link rel="stylesheet" href="<?php echo $this->getThemeUrl('css/style.css');?>">
      </head>
      <body>
            <header id="header">
                     <center><a href="<?php echo Framework::createUrl('request/contact');?>" class="btn head-btn">تماس با ما</a></center>
            </header>
            <div class="container">
                  <?php echo $content;?>
                  <center style="float:left;width:100%;margin-top:20px;">Programmed and Designed By <a target="_blank" href="http://www.tphp.ir">TPHP</a> - all rights reserved</center>
            </div>
      </body>
</html>