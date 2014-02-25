<?php
use framework\session\Session;
$this->title .= ' - پرداخت';
?>
<section class="main">
          <hgroup><h3>پرداخت</h3></hgroup>
          <div class="line"></div>
          <?php foreach(\framework\session\Session::instance()->getFlashes() as $key => $value){?>
              <div class="alert alert-<?php echo $key;?>"><?php echo $value;?></div>
          <?php }?>
</section>