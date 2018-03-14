<?php
$form =\yii\widgets\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'parent_id')->dropDownList($res);
echo $form->field($model,'url')->dropDownList(backend\models\Menu::getPermissions());
echo $form->field($model,'port')->textInput();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\widgets\ActiveForm::end();