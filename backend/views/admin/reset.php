<?php
$form=\yii\widgets\ActiveForm::begin();
echo $form->field($models,'passwords')->passwordInput();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\widgets\ActiveForm::end();