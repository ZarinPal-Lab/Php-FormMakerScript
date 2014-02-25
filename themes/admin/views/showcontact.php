<?php
use framework\helpers\Html;
$this->title .= ' - مشاهده درخواست تماس';
if($contact) {
?>
<form method="POST">
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>مشاهده درخواست تماس</h3></hgroup>
               <div class="well well-inner">
                     <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                   <tr><td>نام و نام خانوادگی</td><td><?php echo Html::escape($contact->contactName);?></td></tr>
                                   <tr><td>ایمیل</td><td><?php echo Html::escape($contact->contactEmail);?></td></tr>
                                   <tr><td>آی پی</td><td><?php echo Html::escape($contact->contactIp);?></td></tr>
                                   <tr><td>زمان ارسال</td><td><?php echo $this->date($contact->contactDate);?></td></tr>
                                   <tr><td>وضعیت</td><td><?php echo ($contact->contactRead == 1 ? '<font color=green>خوانده شده</font>' : '<font color=red>خوانده نشده</font>');?></td></tr>
                                   <tr><td>موضوع</td><td><?php echo Html::escape($contact->contactSubject);?></td></tr>
                            </tbody>
                     </table>
                     <p class="text"><?php echo nl2br(Html::escape($contact->contactContent));?></p>
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
               <hgroup><h3>مشاهده درخواست تماس</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>