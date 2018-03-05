<?php
$form=\yii\widgets\ActiveForm::begin();
echo $form->field($model,'username')->textInput();
echo $form->field($model,'passwords')->passwordInput();
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email')->textInput();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\widgets\ActiveForm::end();