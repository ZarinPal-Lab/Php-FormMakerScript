<?php
use framework\helpers\Html;
use framework\security\Csrf;
if($form) {
       $this->title .= "- {$form->formName}";
?>
<section>
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3><?php echo Html::escape($form->formName);?></h3></hgroup>
                            <p><?php echo Html::escape($form->formDescription);?></p>
                            <form method="POST" name="myForm">
                                   <table class="table">
                                          <tbody>
                                                 <div style="display:none"><?php echo Html::hiddenField('csrf',['value' => Csrf::generate()],false);?></div>
                                                 <tr>
                                                        <td width="140"><label for="name">نام و نام خانوادگی<span>*</span></label></td><td><?php echo Html::textField('name', ['id' => 'name', 'class' => 'form-control']);?><?php echo $model->getMessage('name');?></td>
                                                 </tr>
                                                 <tr>
                                                        <td width="140"><label for="email">ایمیل<span>*</span></label></td><td><?php echo Html::textField('email', ['id' => 'email', 'class' => 'form-control']);?><?php echo $model->getMessage('email');?></td>
                                                 </tr>
                                                 <tr>
                                                        <td width="140"><label for="mobile">موبایل</label></td><td><?php echo Html::textField('mobile', ['id' => 'mobile', 'class' => 'form-control']);?><?php echo $model->getMessage('mobile');?></td>
                                                 </tr>
                                                 <tr>
                                                        <td width="140"><label for="content">توضیحات</label></td><td><?php echo Html::textArea('content', $form->formContent, ['id' => 'content', 'class' => 'form-control', 'rows' => 3]);?><?php echo $model->getMessage('content');?></td>
                                                 </tr>
                                                 
                                                 <tr>
                                                        <td width="140"><label for="price">مبلغ (تومان)<span>*</span></label></td><td><?php echo $this->priceField( $form->formPriceType, $form->formPriceValue );?><?php echo $model->getMessage('price');?></td>
                                                 </tr>
                                                 <tr>
                                                        <td width="140"><label for="gateway">درگاه پرداخت<span>*</span></label></td><td><?php echo Html::dropDownList('gateway', Html::convertObjectToDropDownList($modules,'moduleId','moduleName'), ['id' => 'gateway', 'class' => 'form-control']);?><?php echo $model->getMessage('gateway');?></td>
                                                 </tr>
                                                 <tr>
                                                        <td width="140"><button type="submit" class="btn myBtn"><span class="glyphicon glyphicon-chevron-left"></span> دریافت فاکتور</button></td>
                                                 </tr>
                                          </tbody>
                                   </table>
                                   <?php foreach(\framework\session\Session::instance()->getFlashes() as $key => $value) {?>
                                          <div class="alert alert-<?php echo $key;?>"><?php echo $value;?></div>
                                   <?php }?>
                            </form>
                     </div>
              </div>
       </div>
</section>
<?php } else {?>
<section id="content">
       <div class="container-form">
              <div class="form">
                     <div class="form-inner">
                            <hgroup><h3>خطا</h3></hgroup>
                            <p>چیزی یافت نشد</p>
                     </div>
              </div>
       </div>
</section>
<?php }?>