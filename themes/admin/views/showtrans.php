<?php
use framework\helpers\Html;
$this->title .= ' - مشاهده تراکنش';
if($trans) {
?>
<form method="POST">
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>مشاهده تراکنش</h3></hgroup>
               <div class="well well-inner">
                     <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                   <tr><td>شماره تراکنش</td><td><?php echo Html::escape($trans->transId);?></td></tr>
                                   <tr><td>فرم تراکنش</td><td><a href="<?php echo Framework::createUrl('admin/editform',['id' => Html::escape($trans->transFormId)]);?>">form <?php echo Html::escape($trans->transFormId);?></a></td></tr>
                                   <tr><td>آیتم تراکنش</td><td><a href="<?php echo Framework::createUrl('admin/showitem',['id' => Html::escape($trans->transSaveId)]);?>">item <?php echo Html::escape($trans->transSaveId);?></a></td></tr>
                                   <tr><td>مبلغ </td><td><?php echo Html::escape($trans->transPrice);?> تومان</td></tr>
                                   <tr><td>درگاه پرداخت</td><td><?php echo Html::escape($trans->moduleName);?></td></tr>
                                   <tr><td>کد پیگیری</td><td><?php echo Html::escape($trans->transAu);?></td></tr>
                                   <tr><td>کد پیگیری درگاه</td><td><?php echo Html::escape($trans->transGatewayAu);?></td></tr>
                                   <tr><td>آی پی</td><td><?php echo Html::escape($trans->transIp);?></td></tr>
                                   <tr><td>زمان</td><td><?php echo $this->date($trans->transDate);?></td></tr>
                                   <tr><td>وضعیت</td><td><?php echo ($trans->transStatus == 1 ? '<font color=green>پرداخت شده</font>' : '<font color=red>پرداخت نشده</font>');?></td></tr>
                            </tbody>
                     </table>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>
<?php } else {?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>مشاهده تراکنش</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>