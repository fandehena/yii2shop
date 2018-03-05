<table class="table table-responsive">
    <?php
    $form = \yii\bootstrap\ActiveForm::begin();
    echo $form->field($model,'imgFile')->fileInput();
    echo '<button type="submit" class="btn btn-primary">提交</button>';
    \yii\bootstrap\ActiveForm::end();
    ?>
    <?php foreach($photos as $photo):?>
        <tr>
            <td>
                <img src="<?=$photo->path;?>" class="img-circle">
            <a href="<?=\yii\helpers\Url::to(['goods/del','id'=>$photo->id])?>">删除
            </td>
        </tr>
    <?php endforeach;?>
</table>
