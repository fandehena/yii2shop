<table class="table table-responsive table-bordered">

    <thead>
    <tr>
        <th>名称</th>
        <th>上级菜单</th>
        <th>路由</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($menus as $menu):?>
        <tr  data-id="<?=$menu->id?>">
            <td><?=$menu->name?></td>
            <td><?=$menu->menu?></td>
            <td><?=$menu->url?></td>
            <td><?=$menu->port?></td>
            <td><a class="btn btn-primary" href="<?=\yii\helpers\Url::to(['menu/edit','id'=>$menu->id])?>">修改</a>
                <a href="javascript:" class="btn btn-danger btn_del">删除

        </tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['menu/add'],['class'=>'btn btn-info'])?>
    </tbody>
</table>
<?php
$this->registerCssFile('@web/datalables/css/dataTables.bootstrap.css');

$this->registerJsFile('@web/datalables/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::class]);
$this->registerJsFile('@web/datalables/js/dataTables.bootstrap.js',
    ['depends'=>\yii\web\JqueryAsset::class]);
$this->registerJs('$(".table").DataTable({
language: {
        "sProcessing":   "处理中...",
	"sLengthMenu":   "显示 _MENU_ 项结果",
	"sZeroRecords":  "没有匹配结果",
	"sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
	"sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
	"sInfoFiltered": "(由 _MAX_ 项结果过滤)",
	"sInfoPostFix":  "",
	"sSearch":       "搜索:",
	"sUrl":          "",
	"sEmptyTable":     "表中数据为空",
	"sLoadingRecords": "载入中...",
	"sInfoThousands":  ",",
	"oPaginate": {
		"sFirst":    "首页",
		"sPrevious": "上页",
		"sNext":     "下页",
		"sLast":     "末页"
	},
	"oAria": {
		"sSortAscending":  ": 以升序排列此列",
		"sSortDescending": ": 以降序排列此列"
	}
	}
});');
$url=\yii\helpers\Url::to(['menu/delete']);
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