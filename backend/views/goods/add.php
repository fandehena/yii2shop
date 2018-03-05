<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'logo')->hiddenInput();
$this->registerCssFile('@web/webupload/webuploader.css');
$this->registerJsFile('@web/webupload/webuploader.js',[
    'depends'=>\Yii\web\JqueryAsset::className()
]);
echo <<<HTML
<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>
HTML;
$upload_url=\yii\helpers\Url::to('logo-upload');
$this->registerJs(
    <<<JS
// 初始化Web Uploader
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf:'/webupload/Uploader.swf',

    // 文件接收服务端。
    server: '{$upload_url}',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
uploader.on( 'uploadSuccess', function( file,response ) {
    var imgUrl = response.url;
    $("#goods-logo").val(imgUrl);
    $("#logo-look").attr('src',imgUrl);
});
JS
);
echo '<img src="" id="logo-look" width="50px">';
echo $form->field($parent,'parent_id')->hiddenInput();
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
        zTreeObj.selectNode(zTreeObj.getNodeByParam('id',"{$parent->parent_id}",null))
JS
);
//html代码
echo '<div>
   <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'brand_id')->dropDownList($model->brands);
echo $form->field($model,'market_price')->textInput();
echo $form->field($model,'shop_price')->textInput();
echo $form->field($model,'stock')->textInput();
echo $form->field($model,'is_on_sale')->radioList([
    0=>'上架',
    1=>'下架'
]);
echo $form->field($model,'status')->radioList([
    1=>'删除',
    0=>'正常'
]);
echo $form->field($model,'sort')->textInput();
echo $form->field($models,'content')->widget('kucha\ueditor\UEditor',[
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