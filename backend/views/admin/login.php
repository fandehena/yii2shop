<?php
 $form = yii\bootstrap\ActiveForm::begin();
 echo $form->field($model,'username')->textInput();
 echo $form->field($model,'password')->passwordInput();
 echo $form->field($model,'member')->checkbox();
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::class,['captchaAction'=>'admin/captcha','template'=>'<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-2">{input}</div></div>'])->label('验证码');
 echo '<button type="submit" class="btn btn-default">登陆</button>';
 yii\bootstrap\ActiveForm::end();