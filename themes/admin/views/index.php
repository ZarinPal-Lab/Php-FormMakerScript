<?php
use framework\helpers\Html;
$this->title .= ' - پیشخوان';
?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>پیشخوان</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert" style="margin-bottom:-20px;">در حال حاظر <span class="badge badge-danger"><?php echo Html::escape($contact->count);?></span> درخواست تماس خوانده نشده دارید</div>
                     <div class="alert">تعداد تراکنش های موفق از 1 روز گذشته <span class="badge badge-success"><?php echo Html::escape($trans->count);?></span>  و مبلغ کل این تراکنش ها <span class="badge badge-success"><?php echo number_format($amount->amount);?></span> تومان است</div>
                     <div class="line"></div>
                     <div class="table-responsive">
                           <table class="table table-hover table-striped table-bordered">
                                 <thead><th>کل تراکنش ها</th><th>کل تراکنش های پرداخت شده</th><th>کل تراکنش های پرداخت نشده</th></thead>
                                 <tbody><td><?php echo Html::escape($allTrans->count);?></td><td><?php echo Html::escape($successTrans->count);?></td><td><?php echo Html::escape($allTrans->count-$successTrans->count);?></td></tbody>
                           </table>
                           <table class="table table-hover table-striped table-bordered">
                                 <thead><th>مبلغ کل تراکنش ها</th><th>مبلغ کل تراکنش های پرداخت شده</th><th>مبلغ کل تراکنش های پرداخت نشده</th></thead>
                                 <tbody><td><?php echo Html::escape(number_format($allTransAmount->amount));?> تومان</td><td><?php echo Html::escape(number_format($successTransAmount->amount));?> تومان</td><td><?php echo Html::escape(number_format($allTransAmount->amount-$successTransAmount->amount));?> تومان</td></tbody>
                           </table>
                     </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>