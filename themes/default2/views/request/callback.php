<?php
use framework\helpers\Html;
$this->title .= ' - نتیجه پرداخت';
?>
<section>
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3>نتیجه پرداخت</h3></hgroup>
                            <p></p>
                            <?php if($trans) {?>
                                   <?php echo nl2br($trans->afterPaymentContent);?>
                                   <table class="table table-striped">
                                          <tbody>
                                                 <tr>
                                                        <td><span class="glyphicon glyphicon-info-sign"></span> شماره تراکنش</td> <td><?php echo Html::escape($trans->transId);?></td>
                                                 </tr>
                                                 <tr>
                                                        <td><span class="glyphicon glyphicon-barcode"></span> کد پیگیری</td> <td><?php echo Html::escape($trans->transAu);?></td>
                                                 </tr>
                                                 <tr>
                                                        <td><span class="glyphicon glyphicon-barcode"></span> کد پیگیری از درگاه</td> <td><?php echo Html::escape($trans->transGatewayAu);?></td>
                                                 </tr>
                                                 <tr>
                                                        <td><span class="glyphicon glyphicon-shopping-cart"></span> مبلغ پرداخت شده</td> <td><?php echo Html::escape($trans->transPrice);?> تومان</td>
                                                 </tr>
                                          </tbody>
                                   </table>
                            <?php }?>
                            <?php foreach(\framework\session\Session::instance()->getFlashes() as $key => $value){?>
                                 <div class="alert alert-<?php echo $key;?>"><?php echo $value;?></div>
                            <?php }?>
                     </div>
              </div>
       </div>
</section>