<table class="table table-responsive">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($goods as $good):?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=str_repeat('--',$good->depth).$good->name?></td>
            <td><?=$good->intro?></td>
            <td><a href="<?=\yii\helpers\Url::to(['goods-category/edit','id'=>$good->id])?>">修改</a>
                <a href="<?=\yii\helpers\Url::to(['goods-category/delete','id'=>$good->id])?>">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-info'])?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager]);

