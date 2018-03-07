<table class="table table-responsive">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($goods as $good):?>
        <tr data-id="<?=$good->id?>">
            <td><?=$good->id?></td>
            <td><?=str_repeat('--',$good->depth).$good->name?></td>
            <td><?=$good->intro?></td>
            <td><a href="<?=\yii\helpers\Url::to(['goods-category/edit','id'=>$good->id])?>">修改</a>
                <a href="javascript:" class="btn btn-danger btn_del">删除
            </td>
        </tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-info'])?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,
    'hideOnSinglePage'=>0]);
$url=\yii\helpers\Url::to(['admin/delete']);
$this->registerJs(
    <<<JS
$(".btn_del").click(function(){
    if(confirm("确定删除吗?")){
       
       var tr=$(this).closest('tr');
       var id=tr.attr('data-id');
            $.get("{$url}",{id:id},function(data) {
              if(data=='success'){
                  console.log('删除成功');
                  tr.remove();
              }
            });
    }
})
JS
);

