<table class="table table-responsive">
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>简介</th>
        <th>LOGO图片</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($articles as $article):?>
        <tr>
            <td><?=$article->id?></td>
            <td><?=$article->name?></td>
            <td><?=$article->intro?></td>
            <td><img src="<?=$article->logo;?>" class="img-circle" style="width: 50px"></td>
            <td><?=$article->sort?></td>
            <td><a href="<?=\yii\helpers\Url::to(['articlecategory/edit','id'=>$article->id])?>">修改
                    <a href="<?=\yii\helpers\Url::to(['articlecategory/delete','id'=>$article->id])?>">删除</td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\bootstrap\Html::a('添加',['articlecategory/add'],['class'=>'btn btn-info'])?>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager]);
