<table class="table table-responsive">
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>密码</th>
        <th>邮箱</th>
        <th>创建时间</th>
        <th>修改时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>操作</th>
    </tr>
    <?php foreach($admins as $admin):?>
        <tr data-id="<?=$admin->id?>">
            <td><?=$admin->id?></td>
            <td><?=$admin->username?></td>
            <td><?=substr($admin->password_hash,0,8)?></td>
            <td><?=$admin->email?></td>
            <td><?=$admin->created_at?></td>
            <td><?=$admin->updated_at?></td>
            <td><?=$admin->last_login_time?></td>
            <td><?=$admin->last_login_ip?></td>
            <td><a href="<?=\yii\helpers\Url::to(['admin/edit','id'=>$admin->id])?>" class="btn btn-primary">修改
                    <a href="javascript:" class="btn btn-danger btn_del">删除
                    <a href="<?=\yii\helpers\Url::to(['admin/reset','id'=>$admin->id])?>">重置
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\bootstrap\Html::a('添加',['admin/add'],['class'=>'btn btn-info'])?>
<?php
//echo yii\widgets\LinkPager::widget([
//    'pagination'=>$pager,
//    //'hideOnSinglePage'=>0
//]);
/**
 * @var $this \yii\web\View
 */
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
