/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
$(function(){
	//收货人修改
	$("#address_modify").click(function(){
		$(this).hide();
		$(".address_info").hide();
		$(".address_select").show();
	});

	$(".new_address").click(function(){
		$("form[name=address_form]").show();
		$(this).parent().addClass("cur").siblings().removeClass("cur");

	}).parent().siblings().find("input").click(function(){
		$("form[name=address_form]").hide();
		$(this).parent().addClass("cur").siblings().removeClass("cur");
	});

	//送货方式修改
	$("#delivery_modify").click(function(){
		$(this).hide();
		$(".delivery_info").hide();
		$(".delivery_select").show();
	})

	$("input[name=delivery]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//支付方式修改
	$("#pay_modify").click(function(){
		$(this).hide();
		$(".pay_info").hide();
		$(".pay_select").show();
	})

	$("input[name=pay]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//发票信息修改
	$("#receipt_modify").click(function(){
		$(this).hide();
		$(".receipt_info").hide();
		$(".receipt_select").show();
	})

	$(".company").click(function(){
		$(".company_input").removeAttr("disabled");
	});

	$(".personal").click(function(){
		$(".company_input").attr("disabled","disabled");
	});

    $('.delivery_select input[type=radio]').each(function () {
        $(this).change(function () {
            var price = $(this).closest('td').next().text();
            $('.freight').text(price);

            var shop_price = parseInt($('.shop_price').text().substring(1));
            var freight = parseInt(price.substring(1));
            //>>总金额
            $('.sum_price').text((shop_price+freight).toFixed(2));
            //>应付
            $('.cope_with').text((shop_price+freight).toFixed(2));

        });
    });
    var shop_price = parseInt($('.shop_price').text().substring(1));
    var freight = parseInt($('.freight').text().substring(1));
    //>>总金额
    $('.sum_price').text((shop_price+freight).toFixed(2));
    //>应付
    $('.cope_with').text((shop_price+freight).toFixed(2));


});