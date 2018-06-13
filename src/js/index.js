/*
 * 工作区(layout_content/lay_body/layout_box)面板布局
 * 原理：
 * 1.把所有的li的高度值放到数组里面
 * 2.第一行的top都为0
 * 3.计算高度值最小的值是哪个li
 * 4.把接下来的li放到那个li的下面
 */
function liuxiaofan()
{
	var intMargin = 20; /* 列间距 */
	var arrayLi = $("#layout_box li"); /* 按 id获取面板列表 */

	/* 按当前浏览器计算列宽，最小值200px */
	var intColumnWidth = ($("#right_layout")[0].offsetWidth - 80) / 3;
	if (intColumnWidth <= 200)
	{
		intColumnWidth = 200;
	}

	/* 设置所有面板宽度 */
	arrayLi.css('width', intColumnWidth + 'px');

	var li_W = intColumnWidth + intMargin;
	var h = [];/* 记录面板高度的数组 */
/*
 * 根据最小列宽自动换行，自动计算列数
 * 如要根据最小宽度自动换行，则放开该语句，并注释下面固定列数的代码。
 * 窗口的宽度除以面板宽度就是一行能放几个面板
 * var n = $(".lay_body")[0].offsetWidth/li_W|0;
 */

	/* 固定3列 */
	var n = 3;

	for (var i = 0; i < arrayLi.length; i++)
	{
		/* 获取每个面板的高度 */
		li_H = arrayLi[i].offsetHeight;

		if (i < n)
		{
			/* 第一行 */
			h[i] = li_H;/* 把每个li放到数组里面 */
			arrayLi.eq(i).css("top", 0);			/* 第一行的Li的top值为0 */
			arrayLi.eq(i).css("left", i * li_W);	/* 第i个li的左坐标就是i*li的宽度 */
		}
		else
		{
			min_H = Math.min.apply(null, h);		/* 取得数组中的最小值，面板中高度值最小的那个 */
			minKey = getArraykey(h, min_H);			/* 最小的值对应的指针 */
			h[minKey] += li_H + intMargin;			/* 加上新高度后更新高度值 */
			arrayLi.eq(i).css("top", min_H + intMargin);	/* 先得到高度最小的Li，然后把接下来的li放到它的下面 */
			arrayLi.eq(i).css("left", minKey * li_W); 		/* 第i个li的左坐标就是i*li的宽度 */
		}
	}
}

/*
 * 使用for in运算返回数组中某一值的对应项数(比如算出最小的高度值是数组里面的第几个)
 */
function getArraykey(s, v)
{
	for (k in s)
	{
		if (s[k] == v)
		{
			return k;
		}
	}
};

$(function()
{
	var psList = $(".left_menu ul > li");

/* 暂时取消动态改变左侧工具栏高亮
	psList.click(function()
	{
		var itype = $(this).find("a").find("i").attr("iType");
		var iWhite = "icon_" + itype + "_hv";

		 全部移除高亮 
		$(this).siblings().removeClass("selected").find("a").find("i").removeClass(function()
		{
			var itype = $(this).attr("iType");
			var iWhite = "icon_" + itype + "_hv";
			return iWhite;
		});

		 当前添加高亮 
		$(this).find("a").find("i").addClass(iWhite);
		$(this).addClass("selected");
	});*/

	/* top_menu */
	$(".top_menu ul li").click(function()
	{
		$(this).addClass("active").siblings().removeClass("active");
	});

	/* 左侧菜单 */
	$(document).ready(function()
	{
		$("#layout_button").toggle(function()
		{
			$(this).parents("#left_menu_body").animate(
			{
				left : '-201px'
			}, 'fast');

			$(this).animate(
			{
				right : '-10px'
			}, "fast").addClass("layout_button_fiexd");

			$("#right_body").animate(
			{
				marginLeft : '0px'
			}, "fast");

			setTimeout(function()
			{
				liuxiaofan()
			}, 500);
		}, function()
		{
			$(this).parents("#left_menu_body").animate(
			{
				left : '0px'
			}, "fast");

			$(this).animate(
			{
				right : '-10px'
			}, "fast").removeClass("layout_button_fiexd");

			$("#right_body").animate(
			{
				marginLeft : '201px'
			}, "fast");

			setTimeout(function()
			{
				liuxiaofan()
			}, 500);
		});
	});

});