<?php
use framework\helpers\Html;
$this->title = 'exception';
if(framework\core\Config::instance()->getItem('exceptionReporting') === 'onlyMessage') {
?>
<section class="main">
<hgroup><h3 style="text-align:left;">Error</h3></hgroup>
<p style="text-align:left;">Page Cannot be loaded, Please try again</p>
</section>
<?php } else {?>
<section class="main">
<hgroup><h3 style="text-align:left;"><?php echo Html::escape($exception->getMessage());?></h3></hgroup>
<p style="text-align:left;"><?php echo Html::escape($exception->getFile());?> on line <?php echo Html::escape($exception->getLine());?></p>
</section>
<?php }?>