<section id="content">
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3>پرداخت</h3></hgroup>
                            <p></p>
                            <?php foreach(\framework\session\Session::instance()->getFlashes() as $key => $value){?>
                                   <div class="alert alert-<?php echo $key;?>"><?php echo $value;?></div>
                            <?php }?>
                     </div>
              </div>
       </div>
</section>