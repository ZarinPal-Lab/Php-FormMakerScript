<?php
use framework\helpers\Html;
if( $factor ) {
       $this->title .= ' - مشاهده فاکتور';
?>
<section class="main">
          <hgroup><h3>مشاهده فاکتور </h3></hgroup>
          <p><b>لطفا کد پیگیری را برای مراجعات بعدی یادداشت نمایید</b></p>
          <div class="line"></div>
          <div class="clear"></div>
          <div class="col-md-12">
              <table class="table table-striped">
                     <tr>
                            <td><span class="glyphicon glyphicon-info-sign"></span> شماره تراکنش</td> <td><?php echo Html::escape($factor->transId);?></td>
                     </tr>
                     <tr class="danger">
                            <td><span class="glyphicon glyphicon-barcode"></span> کد پیگیری</td> <td><?php echo Html::escape($factor->transAu);?></td>
                     </tr>
                     <?php if($factor->transGatewayAu) {?>
                     <tr class="danger">
                            <td><span class="glyphicon glyphicon-barcode"></span>کد پیگیری از درگاه</td> <td><?php echo Html::escape($factor->transGatewayAu);?></td>
                     </tr>
                     <?php }?>
                     <tr>
                            <td><span class="glyphicon glyphicon-user"></span> نام و نام خانوادگی</td> <td><?php echo Html::escape( $factor->saveName );?></td>
                     </tr>
                     <tr>
                            <td><span class="glyphicon glyphicon-envelope"></span> ایمیل</td> <td><?php echo Html::escape( $factor->saveEmail );?></td>
                     </tr>
                     <?php if(!empty($factor->saveMobile)) {?>
                     <tr>
                            <td><span class="glyphicon glyphicon-phone"></span> موبایل</td> <td><?php echo Html::escape( $factor->saveMobile );?></td>
                     </tr>
                     <?php }?>
                     <tr>
                            <td><span class="glyphicon glyphicon-shopping-cart"></span> مبلغ</td> <td><?php echo Html::escape( $factor->transPrice );?> تومان</td>
                     </tr>
                     <tr>
                            <td><span class="glyphicon glyphicon-tasks"></span> درگاه پرداخت</td> <td><?php echo Html::escape( $factor->moduleName );?></td>
                     </tr>
                     <?php if($factor->saveContent) {?>
                     <tr>
                            <td><span class="glyphicon glyphicon-plus"></span> توضیحات</td> <td><?php echo nl2br(Html::escape( $factor->saveContent ));?></td>
                     </tr>
                     <?php }?>
              </table>
          </div>
          <div class="col-md-12">
              <?php if($factor->transStatus == 1){?>
                     <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;فاکتور مورد نظر شما پرداخت شده است</div>
              <?php }elseif($factor->moduleName == null){?>
                     <div class="alert alert-danger">درگاه پرداخت انتخابی وجود ندارد و یا حذف شده است</div>
              <?php }elseif($factor->transStatus == 0){?>
                     <a href="<?php echo \Framework::createUrl('request/gateway', ['au' => Html::escape($factor->transAu)]);?>" class="btn my-btn"><span class="glyphicon glyphicon-chevron-left"></span>پرداخت</a>
              <?php }?>
          </div>
</section>
<?php } else {?>
<section class="main">
       <p>چیزی یافت نشد</p>
</section>
<?php }?>