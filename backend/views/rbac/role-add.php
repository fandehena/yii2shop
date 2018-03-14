<?php
$form= \yii\widgets\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'description')->textInput();
echo $form->field($model,'permission')->checkboxList(\backend\models\RoleForm::getPermissions());
echo '<button type="submit" class="btn btn-primary">提交</button>';
//echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-primary']);
\yii\widgets\ActiveForm::end();