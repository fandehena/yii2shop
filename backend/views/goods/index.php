<?=\yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-info'])?>
<form id="w0" class="form-inline" action="/goods/index" method="get" role="form">
    <div class="form-group field-goodssearchform-name" style="width: 15%">
        <input type="text" id="goodssearchform-name" class="form-control" name="GoodsSearchForm[name]" placeholder="商品名">
    </div>
    <div class="form-group field-goodssearchform-sn has-success" style="width: 15%">
        <input type="text" id="goodssearchform-sn" class="form-control" name="GoodsSearchForm[sn]" placeholder="货号" aria-invalid="false">
    </div>
    <div class="form-group field-goodssearchform-minprice" style="width: 15%">

        <input type="text" id="goodssearchform-minprice" class="form-control" name="GoodsSearchForm[minPrice]" placeholder="￥">


    </div>
    <div class="form-group field-goodssearchform-maxprice" style="width: 15%">
        <label class="sr-only" for="goodssearchform-maxprice">-</label>
        <input type="text" id="goodssearchform-maxprice" class="form-control" name="GoodsSearchForm[maxPrice]" placeholder="￥">


    </div>
    <button type="submit" class="btn btn-default"><span class="glyphiconglyphicon-search"></span>搜索</button>
</form>
<table class="table table-responsive">
<tr>
    <th>id</th>
    <th>商品名称</th>
    <th>货号</th>
    <th>logo图片</th>
    <th>市场价格</th>
    <th>商品价格</th>
    <th>库存</th>
    <th>排序</th>
    <th>添加时间</th>
    <th>操作</th>
</tr>

    <?php foreach ($goods as $good):?>
        <tr>
    <td> <?=$good->id?></td>
    <td><?=$good->name?></td>
    <td><?=$good->sn?></td>
    <td><img src="<?=$good->logo;?>" class="img-circle" style="width: 50px"></td>
    <td><?=$good->market_price?></td>
    <td><?=$good->shop_price?></td>
    <td><?=$good->stock?></td>
    <td><?=$good->sort?></td>
    <td><?=date('Y-m-d H:i:s',$good->create_time)?></td>

        <td><a href="<?=\yii\helpers\Url::to(['goods/edit','id'=>$good->id])?>">修改</a>
            <a href="<?=\yii\helpers\Url::to(['goods/delete','id'=>$good->id])?>">删除</a>
            <a href="<?=\yii\helpers\Url::to(['goods/photo','id'=>$good->id])?>">图片墙</a>
        </td>
</tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager]);
