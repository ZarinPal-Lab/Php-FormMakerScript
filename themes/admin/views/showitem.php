<?php
use framework\helpers\Html;
$this->title .= ' - مشاهده آیتم';
if($save) {
?>
<form method="POST">
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>مشاهده آیتم</h3></hgroup>
               <div class="well well-inner">
                     <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                   <tr><td>شماره آیتم</td><td><?php echo Html::escape($save->saveId);?></td></tr>
                                   <tr><td>فرم</td><td><a href="<?php echo Framework::createUrl('admin/editform',['id' => Html::escape($save->saveFormId)]);?>">form <?php echo Html::escape($save->saveFormId);?></a></td></tr>
                                   <tr><td>نام و نام خانوادگی</td><td><?php echo Html::escape($save->saveName);?></td></tr>
                                   <tr><td>ایمیل</td><td><?php echo Html::escape($save->saveEmail);?></td></tr>
                                   <tr><td>موبایل</td><td><?php echo Html::escape($save->saveMobile);?></td></tr>
                                   <tr><td>آی پی</td><td><?php echo Html::escape($save->saveIp);?></td></tr>
                                   <tr><td>زمان</td><td><?php echo $this->date($save->saveDate);?></td></tr>
                            </tbody>
                     </table>
                     <p class="text"><?php echo nl2br(Html::escape($save->saveContent));?></p>
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
               <hgroup><h3>مشاهده آیتم</h3></hgroup>
               <div class="well well-inner">
                     <div class="alert alert-danger">چیزی یافت نشد</div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
<?php }?>