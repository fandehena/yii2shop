<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'imgFile')->fileInput();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();