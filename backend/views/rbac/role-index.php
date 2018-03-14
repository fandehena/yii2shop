<table class="table table-responsive table-bordered">

    <thead>
    <tr>
        <th>权限名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($permissions as $permission):?>
        <tr>
            <td><?=$permission->name?></td>
            <td><?=$permission->description?></td>
            <td><a class="btn btn-primary" href="<?=\yii\helpers\Url::to(['rbac/role-edit','name'=>$permission->name])?>">修改</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['rbac/role-delete','name'=>$permission->name])?>">删除</a></td>
        </tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['rbac/add-role'],['class'=>'btn btn-info'])?>
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
