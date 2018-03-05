<?php
$form=\yii\widgets\ActiveForm::begin();
echo $form->field($model,'username')->textInput();
echo $form->field($model,'password')->textInput();
echo $form->field($model,'passwords')->textInput();
echo $form->field($model,'email')->textInput();
echo '<button type="submit" class="btn btn-primary"></button>';
\yii\widgets\ActiveForm::end();
