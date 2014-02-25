<?php
use framework\helpers\Html;
use framework\security\Csrf;
$this->title .= ' - آیتم ها';
?>
<form method="POST">
<?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?>
<div class="container">
       <div class="col-xs-9">
         <div id="content" class="well">
               <hgroup><h3>آیتم ها</h3></hgroup>
               <div class="well well-inner">
               <?php foreach(framework\session\Session::instance()->getFlashes() as $key => $message){?>
                     <div class="alert alert-<?php echo $key;?>"><?php echo $message;?></div>
               <?php }?>
			   <div class="table-responsive">
               <table class="table table-hover table-striped table-bordered my-table">
                     <thead><th>#</th><th>انتخاب</th><th>فرم</th><th>نام و نام خانوادگی</th><th>ایمیل</th><th>زمان</th><th>مشاهده</th></thead>
                     <tbody>
                            <?php foreach($save as $item){?>
                                   <tr>
                                          <td><?php echo Html::escape($item->saveId);?></td>
                                          <td><label class="check-box"><input type="checkbox" name="pick[]" value="<?php echo Html::escape($item->saveId);?>"><span></span></label></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/editform',['id' => Html::escape($item->saveFormId)]);?>">form <?php echo Html::escape($item->saveFormId);?></a></td>
                                          <td><?php echo Html::escape($item->saveName);?></td>
                                          <td><?php echo Html::escape($item->saveEmail);?></td>
                                          <td><?php echo $this->date($item->saveDate);?></td>
                                          <td><a href="<?php echo Framework::createUrl('admin/showitem',['id' => Html::escape($item->saveId)]);?>"><img src="<?php echo $this->getThemeUrl('img/show.png');?>"></a></td>
                                   </tr>
                            <?php }?>
                     </tbody>
               </table>
			   </div>
               <?php echo $pagination->createPages();?>
              <div class="form-group">
                     <input type="submit" class="btn btn-danger" value="حذف آیتم های انتخاب شده">
              </div>
               </div>
         </div>
       </div>
<?php $this->renderPartial('sidebar');?>
</div>
</form>