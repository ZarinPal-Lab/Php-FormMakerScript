<?php
use framework\helpers\Html;
$this->title .= ' - error';
?>
<section id="content">
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3 style="text-align:left;"><?php echo Html::escape($errStr);?> on line <?php echo Html::escape($errLine);?></h3></hgroup>
                            <p style="text-align:left;"><?php echo Html::escape($errFile);?></p>
                     </div>
              </div>
       </div>
</section>