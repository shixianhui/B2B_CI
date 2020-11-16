

(function(a){
	a.fn.hoverClass=function(b){
		var a=this;
		a.each(function(c){
			a.eq(c).hover(function(){
				$(this).addClass(b)
			},function(){
				$(this).removeClass(b)
			})
		});
		return a
	};
})(jQuery);

$(function(){
	$("#link1").hoverClass("current");
	$("#link2").hoverClass("current");
	$("#link3").hoverClass("current");
	$("#link4").hoverClass("current");
	$("#activity").hoverClass("current");
});

/*下拉菜单*/
$("li.sure.search_price").hover(
	function () {
		$('em.sure-btn').css('display', 'inline');
	},
	function () {
		$('em.sure-btn').css('display', 'none');
	}
);

$('.price-down').on('mouseover',function(){
	$('.price-down .down-menu').css('display','block');
}).on('mouseout',function(){
	$('.price-down .down-menu').css('display','none');
})

$('.price-down .down-menu .down-list').on('click',function(){
	$('.price-down>a').text($(this).text());
	$('.price-down .down-menu').css('display','none');
})


//点击切换城市效果
    $('.tigCity').click(function () {
        if ($('.clickCity').hasClass('on')) {
            $(this).parent().removeClass('on');
            $(this).parent().siblings('.tabCityBox').removeClass('on');
        } else {
            $(this).parent().addClass('on');
            $(this).parent().siblings('.tabCityBox').addClass('on');
        }
    });
    $(document).click(function (e) {
        var target = $(e.target);
        if (target.closest(".clickCity").length == 0) {
            $(".tigCity").parent().removeClass('on');
            $(".tigCity").parent().siblings('.tabCityBox').removeClass('on');
        }
    });

    $('#city_lists').on('click', 'span', function () {
        var thisHtml = $(this).html();
        $('#city_txt').children('font').html(thisHtml);
    });

    //点击城市更换城市
    $('.city a').click(function () {
        var aHtml = $(this).html();
        $(this).parents('.tabCityBox').removeClass('on');
        $(this).parents('.tabCityBox').siblings('.clickCity').removeClass('on');
        $(this).parents('.tabCityBox').siblings('.clickCity').children('span').html(aHtml);
        $('.city a').removeClass('on');
        $(this).addClass('on');
    });

//导航公告滚动
jQuery(".txtScroll-top").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:true,vis:1});
jQuery(".product-recommend").slide({trigger:"click"});
$('.recommend-item li').mouseenter(function(){
			$(this).find('.mask').stop().animate({bottom:'0px',height:'40px'});
			
			
		})
		$('li').mouseleave(function(){
			$(this).find('.mask').stop().animate({bottom:'-10px',height:'0px'});
			
			
		})
jQuery(".product-comment").slide({});	
jQuery(".bank_pay").slide({trigger:"click"});
jQuery(".member_tab").slide({effect:"fold",trigger:"click"});

 //选择删除复选框 
$("span[name='checkWeek']").click(function(){ 
if($(this).hasClass('CheckBoxSel')){ 
$(this).removeClass('CheckBoxSel'); 
}else{ 
$(this).addClass('CheckBoxSel'); 
} 
}); 	

//首页左侧分类菜单
$(function(){
	$(".category ul.menu").find("li").each(
		function() {
			$(this).hover(
				function() {
				    var cat_id = $(this).attr("cat_id");
					var menu = $(this).find("div[cat_menu_id='"+cat_id+"']");
					menu.show();
					$(this).addClass("hover");					
					var menu_height = menu.height();
					if (menu_height < 60) menu.height(80);
					menu_height = menu.height();
					var li_top = $(this).position().top;
					$(menu).css("top",-li_top + 0);
				},
				function() {
					$(this).removeClass("hover");
				    var cat_id = $(this).attr("cat_id");
					$(this).find("div[cat_menu_id='"+cat_id+"']").hide();
				}
			);
		}
	);
	
});

//焦点图
jQuery(".fullSlide").find(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("show",1) },function(){ jQuery(this).find(".prev,.next").fadeOut() });				jQuery(".fullSlide").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click",			startFun:function(i){				var curLi = jQuery(".fullSlide .bd li").eq(i); 				if( !!curLi.attr("_src") ){					curLi.css("background-image",curLi.attr("_src")).removeAttr("_src") 				}			}		});	


//选择框
$(function(){
	$(".select").each(function(){
		var s=$(this);
		var z=parseInt(s.css("z-index"));
		var dt=$(this).children("dt");
		var dd=$(this).children("dd");
		var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   
		var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    
		dt.click(function(){dd.is(":hidden")?_show():_hide();});
		dd.find("a").click(function(){dt.html($(this).html());_hide();}); 
		$("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
	})
})

jQuery(".floor-slide").slide({mainCell:".bd ul",effect:"left",autoPlay:true});
jQuery(".floor-slide1").slide({mainCell:".bd ul",effect:"left",autoPlay:true});
jQuery(".helpmenu").slide({titCell:"h3", targetCell:"ul",defaultIndex:0,effect:"slideDown",delayTime:300,trigger:"click"});

//产品筛选
$(".option").on('click', '.o-more', function() {
			var $this = $(this);
			if ($this.hasClass('sel_act')) {
				$this.removeClass('sel_act');
				$this.parents('.condition').removeClass('h');
			} else {
				$this.addClass('sel_act');
				$this.parents('.condition').addClass('h');
			}
		});

$(".option1").on('click', '.o-more1', function() {
			var $this = $(this);
			if ($this.hasClass('sel_act1')) {
				$this.removeClass('sel_act1');
				$this.parents('.condition1').removeClass('h');
			} else {
				$this.addClass('sel_act1');
				$this.parents('.condition1').addClass('h');
			}
		});
		
$(function(){
	$('.live-box ul li').hover(function(){
	  $(this).find('.mask').stop().animate({'bottom':'0px'},800);
	},function(){
	  $(this).find('.mask').stop().animate({'bottom':'-40px'},800);
	});
	$('.live-box ul li').hover(function(){
	  $(this).find('.video').stop().animate({'opacity':'100'},800);
	},function(){
	  $(this).find('.video').stop().animate({'opacity':'0'},800);
	});
	
	
});

//后来添加的js效果

$(function(){
	/*tab选项卡*/
	$('.control ul li').on('click',function(){
		
		$(this).attr('class','active').siblings().attr('class','');
		$('.tab-wrap .tab-box').eq($(this).index()).css('display','block').siblings().css('display','none');
	})
	
	
	/*鼠标移入link1之后person-box显示，移出隐藏*/
	$('.fix-service .link1').hover(function(){
		$('.fix-service .person-box').slideDown(400);
	},function(){
		$('.fix-service .person-box').slideUp(400);
	})
	

	/*页面滚动距离超出可视区高度显示fix-service，否则隐藏fix-service*/
	$(window).scroll(
		function(){
			var ts=$(this).scrollTop();
			if(ts>document.documentElement.clientHeight/4){
				$('.fix-service').fadeIn();
			}else{
				$('.fix-service').fadeOut();
			}
		}
	);
	
	/**/
	$('.fix-service .link2').on('click',function(){
		$('html body').animate({'scrollTop':0});
	})	
})

//头部广告
window.onload=function(){setTimeout('dakai()',1000);} ; //打开页面后3秒显示出DIV
function dakai(){$(".topad").slideDown("slow");setTimeout('guanbi()',10000);};//显示出DIV后5秒关闭
function guanbi(){$(".topad").slideUp("slow");};
function colose_ad() {
    $(".topad").slideUp("slow");
}