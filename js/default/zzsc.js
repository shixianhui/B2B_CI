// JavaScript Document
$(document).ready(function(e) {
	linum = $('.mainlist li').length;//图片数量
	w = linum * 90;//ul宽度
    page = Math.ceil(linum/5);
	$('.piclist').css('width', w + 'px');//ul宽度

	$('.og_next').click(function(){

		if($('.swaplist,.mainlist').is(':animated')){
			$('.swaplist,.mainlist').stop(true,true);
		}

        if($('.mainlist li').length>5){//多于4张图片
			ml = parseInt($('.mainlist').css('left'));//默认图片ul位置
			if(ml<=0 && ml*-1+450<page*450){//默认图片显示时
                $('.mainlist').animate({left: ml - 450 + 'px'}, 'slow');//默认图片滚动
			}
		}
	});

	$('.og_prev').click(function(){

		if($('.swaplist,.mainlist').is(':animated')){
			$('.swaplist,.mainlist').stop(true,true);
		}

		if($('.mainlist li').length>5){
			ml = parseInt($('.mainlist').css('left'));
			if(ml<0 && ml>w*-1) {
                $('.mainlist').animate({left: ml + 450 + 'px'}, 'slow');
            }
		}
	});
});

$(document).ready(function(){
    $('.swaplist').css({left: '450px'});
	$('.og_prev,.og_next').hover(function(){
			$(this).fadeTo('fast',1);
		},function(){
			$(this).fadeTo('fast',0.7);
	})

});

