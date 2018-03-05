<?php
/**
* @var $this \yii\web\view
 */
use \kucha\ueditor\UEditor;
$form =\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'parent_id')->hiddenInput();
//======ztree ============//
$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',[
    'depends'=>\yii\web\JqueryAsset::class
]);
$this->registerJs(
    <<<JS
  var zTreeObj;
   // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
   var setting = {
       data: {
           simpleData: {
               enable: true,
               idKey: "id",
               pIdKey: "parent_id",
               rootPId: 0
           }
           },
       callback:{
              onClick: function zTreeOnClick(event, treeId, treeNode) {
                   // alert(treeNode.tId + ", " + treeNode.name);
                   $("#goodscategory-parent_id").val(treeNode.id)
           }
   }
   };
   // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes ={$nodes};
       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
        zTreeObj.selectNode(zTreeObj.getNodeByParam('id',"{$model->parent_id}",null))
JS
);
//html代码
echo '<div>
   <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'intro')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'en', //中文为 zh-cn
        //定制菜单
        'toolbars' => [
            [
                'fullscreen', 'source', 'undo', 'redo', '|',
                'fontsize',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                'forecolor', 'backcolor', '|',
                'lineheight', '|',
                'indent', '|'
            ],
        ]
]
]);
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();