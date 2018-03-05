<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/5 0005
 * Time: 14:38
 */
$form =\yii\widgets\ActiveForm::begin();
echo $form->field($model,'username')->textInput(['disable'=>true]);
echo $form->field($model,'old')->passwordInput();
echo $form->field($model,'new')->passwordInput();
echo $form->field($model,'confirm')->passwordInput();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\widgets\ActiveForm::end();