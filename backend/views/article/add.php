<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($models,'content')->textarea();
echo $form->field($model,'article_category_id')->dropDownList($model->articles);
echo $form->field($model,'sort')->textInput();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();
