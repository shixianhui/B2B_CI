<style type="text/css">
    .click_1{width:750px; height:140px !important;top:200px;position:absolute;left:50%;margin-left:-375px;}
    .click_2{width:270px; height:120px !important;bottom:0;left:;position:absolute;left:50%;margin-left:-375px;}
    .click_3{width:270px; height:120px !important;bottom:0;position:absolute;right:50%;margin-right:-375px;}
</style>
<?php $adList = $this->advdbclass->getAd(28, 10);
if ($adList) { ?>
    <div class="fullSlide">
        <div class="bd">
            <ul>
                <?php foreach ($adList as $ad) { ?>
                    <li _src="url(<?php echo $ad['path']; ?>)" style="background:center 0 no-repeat;">
                        <?php if ($ad['id'] == 44) { ?>
                            <a class="click_1" href="javascript:;"></a>
                            <a class="click_2" href="javascript:;"></a>
                            <a class="click_3" href="javascript:;"></a>
                        <?php } else { ?>
                            <a target="_blank" href="<?php echo $ad['url']; ?>"></a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <style>
        .mcxq-hd ul{text-align: center;padding: 80px 0;}
        .mcxq-hd ul li{display: inline-block}
        .mcxq-hd ul li a {font-size: 18px; width: 250px;height: 60px;display: block;background-color:#c81624;color: #fff}
        .mcxq-hd ul li a img{display: inline-block;}
    </style>
    <div class="mcxq-hd">
        <ul>
            <li>
                <a href="<?php echo getBaseUrl($html, " ", "store/index/2/282.html ", $client_index); ?>">
                    <div style="padding-top: 10px;"><span>点击进入招商采购频道</span></div>
                    <div><img src="images/default/mcxq-1-1.png" alt=""></div>
                </a>
            </li>
        </ul>
    </div>
<?php } ?>