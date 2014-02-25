<?php
use framework\helpers\Html;
$this->title .= ' - exception';
if(framework\core\Config::instance()->getItem('exceptionReporting') === 'onlyMessage') {
?>
<section id="content">
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3 style="text-align:left;">Error</h3></hgroup>
                            <p style="text-align:left;">Page Cannot be loaded, Please try again</p>
                     </div>
              </div>
       </div>
</section>
<?php } else {?>
<section id="content">
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3 style="text-align:left;"><?php echo Html::escape($exception->getMessage());?></h3></hgroup>
                            <p style="text-align:left;"><?php echo Html::escape($exception->getFile());?> on line <?php echo Html::escape($exception->getLine());?></p>
                     </div>
              </div>
       </div>
</section>
<?php }?>