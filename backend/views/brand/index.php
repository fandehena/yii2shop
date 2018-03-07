<table class="table table-responsive">
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>简介</th>
        <th>LOGO图片</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($brands as $brand):?>
        <tr data-id="<?=$brand->id?>">
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=$brand->intro?></td>
            <td><img src="<?=$brand->logo;?>" class="img-circle" style="width: 50px"></td>
            <td><?=$brand->sort?></td>
            <td><a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$brand->id])?>">修改
                    <a href="javascript:" class="btn btn-danger btn_del">删除
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info'])?>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'hideOnSinglePage'=>0]);
$url=\yii\helpers\Url::to(['brand/delete']);
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
