<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - جستجو';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>جستجو</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>

               <?php if(!$trans) {?>
               <label for="saveName">نام و نام خانوادگی</label>
               <div class="form-group">
                     <?php echo Html::textField('saveName',['class' => 'form-control','id' => 'saveName']);?>
               </div>

               <label for="saveEmail">ایمیل</label>
               <div class="form-group">
                     <?php echo Html::textField('saveEmail',['class' => 'form-control','id' => 'saveEmail']);?>
               </div>
               <?php echo $model->getMessage('saveEmail');?>

               <label for="transAu">کد پیگیری سایت</label>
               <div class="form-group">
                     <?php echo Html::textField('transAu',['class' => 'form-control','id' => 'transAu']);?>
               </div>

               <label for="transGatewayAu">کد پیگیری درگاه</label>
               <div class="form-group">
                     <?php echo Html::textField('transGatewayAu',['class' => 'form-control','id' => 'transGatewayAu']);?>
               </div>

               <label for="transStatus">نوع تراکنش</label>
               <div class="form-group">
                     <?php echo Html::dropDownList('transStatus',['no' => 'مهم نیست',1 => 'پرداخت شده',0 => 'پرداخت نشده'],['class' => 'form-control','id' => 'transStatus']);?>
               </div>

               <label for="limit">تعداد نمایش (DESC)</label>
               <div class="form-group">
                     <?php echo Html::dropDownList('limit',[10 => '۱0 رکورد آخر',20 => '۲0 رکورد آخر',30 => '۳0 رکورد آخر'],['class' => 'form-control','id' => 'limit']);?>
               </div>
               <?php echo $model->getMessage('limit');?>

              <div class="form-group">
                     <input type="submit" class="btn my-btn" value="جستجو">
              </div>
              <?php }else{?>
              <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                     <thead><th>#</th><th>مبلغ تراکنش</th><th>کد پیگیری سایت</th><th>کد پیگیری درگاه</th><th>وضعیت</th><th>مشاهده</th></thead>
                     <?php foreach($trans as $t){?>
                            <tr>
                                   <td><?php echo Html::escape($t->transId);?></td>
                                   <td><?php echo Html::escape($t->transPrice);?></td>
                                   <td><?php echo Html::escape($t->transAu);?></td>
                                   <td><?php echo Html::escape($t->transGatewayAu);?></td>
                                   <td><?php echo ($t->transStatus == 1 ? '<font color=green>پرداخت شده</font>' : '<font color=red>پرداخت نشده</font>');?></td>
                                   <td><a href="<?php echo Framework::createUrl('admin/showtrans',['id' => Html::escape($t->transId)]);?>"><img src="<?php echo $this->getThemeUrl('img/show.png');?>"></a></td>
                            </tr>
                     <?php }?>
              </table>
              </div>
              <?php }?>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>