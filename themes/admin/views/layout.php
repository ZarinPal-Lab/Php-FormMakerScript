<?php
use framework\helpers\Html;
$admin = new app\components\Admin();
?>
<!DOCTYPE HTML>
<html>
<head>
     <title><?php echo Html::escape($this->title);?></title>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width,initial-scale=1.0">
     <link rel="shortcut icon" href="<?php echo $this->getThemeUrl('img/favicon.ico');?>">
     <link rel="stylesheet" href="<?php echo $this->getThemeUrl('css/bootstrap.min.css');?>">
     <link rel="stylesheet" href="<?php echo $this->getThemeUrl('css/style.css');?>">
     <script type="text/javascript" src="<?php echo $this->getThemeUrl('js/jquery.min.js');?>"></script>
     <script type="text/javascript" src="<?php echo $this->getThemeUrl('js/bootstrap.min.js');?>"></script>
     <script type="text/javascript" src="<?php echo $this->getThemeUrl('js/custom.js');?>"></script>
     <?php if($admin->getIsLogged()) {?>
     <script type="text/javascript" src="<?php echo $this->getThemeUrl('ckeditor/ckeditor.js');?>"></script>
     <link rel="stylesheet" href="<?php echo Framework::getSiteUrl();?>assets/pagination.css">
     <?php }?>
</head>
<body>
     <?php if($admin->getIsLogged()){?>
     <header id="header">
           <div class="navbar navbar-inverse">
                 <div class="container">
                       <div class="navbar-header">
                             <a href="<?php echo Framework::getSiteUrl();?>" class="navbar-brand"><?php echo Html::escape($admin->getUserName());?></a>
                       </div>
                       <div class="collapse navbar-collapse" id="head-menu">
                             <ul class="navbar-nav">
                                   <li><a href="<?php echo Framework::createUrl('admin/trans');?>"><span class="glyphicon glyphicon-shopping-cart"></span>تراکنش ها</a></li>
                                   <li><a href="<?php echo Framework::createUrl('admin/search');?>"><span class="glyphicon glyphicon-search"></span>جستجو</a></li>
                                   <li><a href="<?php echo Framework::createUrl('admin/option');?>"><span class="glyphicon glyphicon-wrench"></span>تنظیمات</a></li>
                                   <li><a href="<?php echo Framework::createUrl('admin/logout');?>"><span class="glyphicon glyphicon-log-out"></span>خروج</a></li>
                             </ul>
                       </div>
                 </div>
           </div>
     </header>
     <?php }?>
     <?php echo $content;?>
     <div class="footer">
           <p>Programmed And Designed By <a target="_blank" href="http://www.tphp.ir">TPHP</a> , all rights reserved (<?php echo Framework::getMemoryUsage();?>)</p>
     </div>
</body>
</html>