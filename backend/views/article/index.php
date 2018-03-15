<table class="table table-responsive">
   <tr>
    <th>ID</th>
    <th>名称</th>
    <th>简介</th>
    <th>文章id</th>
    <th>排序</th>
    <th>状态</th>
    <th>创建时间</th>
    <th>操作</th>
   </tr>
    <?php foreach($articles as $article):?>
    <tr data-id="<?=$article->id?>">
        <td><?=$article->id?></td>
        <td><?=$article->name?></td>
        <td><?=$article->intro?></td>
        <td><?=$article->articleCategory->name?></td>
        <td><?=$article->sort?></td>
        <td><?=$article->is_deleted?></td>
        <td><?=date('Y-m-d H:i:s',$article->create_time)?></td>
        <td><a class="btn btn-primary" href="<?=\yii\helpers\Url::to(['article/edit','id'=>$article->id])?>">修改</a>
            <a href="javascript:" class="btn btn-danger btn_del">删除
            <a href="<?=\yii\helpers\Url::to(['article/show','id'=>$article->id])?>">查看</a> </td>
    </tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-info'])?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager,
    'hideOnSinglePage'=>0
]);
$url=\yii\helpers\Url::to(['article/delete']);
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