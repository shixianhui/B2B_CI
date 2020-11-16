<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="box_shadow clearfix m_border">
            <div class="member_title"><span class="bt">充值账户</span></div>
            <ul class="m_form" >
                <li class="clearfix"><span>账户余额：</span><b class="f18 purple"><small>￥</small>50.00</b></li>
                <li class="clearfix"><span>充值金额：</span><input type="" placeholder="" class="input_txt mr15" style="width:180px;">元</li>
                <li class="clearfix"><span>付款方式：</span>
                    <div class="bank_pay">
                        <div class="hd ">
                            <ul>
                                <Li>支付宝</Li>
                                <Li>微信支付</Li>
                                <Li>网银支付</Li>
                            </ul>
                        </div>
                        <div class="bd clearfix">
                            <div class="bank_list">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/bank1.png"></a></dd></dl>
                            </div>
                            <div class="bank_list">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/bank1.png"></a></dd></dl>
                            </div>
                            <div class="bank_list">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/bank1.png"></a></dd></dl>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="clearfix"><span>&nbsp;</span><dl class="m_check"><dd><span name="checkWeek" class="CheckBoxNoSel CheckBoxSel"></span>我同意《资金管理协议》</dd></dl> </li>
                <li class="clearfix">
                    <span>&nbsp;</span><a href="" class="btn_r">提 交</a>
                </li>  
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });

</script>
<script language="javascript" type="text/javascript">
    $(function () {
        $(".checkbox_item dd").click(function () {
            $(this).addClass("clickdd").siblings().removeClass("clickdd");
        })
    })
</script>

<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

