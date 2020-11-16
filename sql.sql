－－2016－12－21－xzp－
ALTER TABLE `product` ADD `material_name` VARCHAR( 50 ) NOT NULL DEFAULT '' COMMENT '材质' AFTER `brand_name` ,
ADD `style` VARCHAR( 50 ) NOT NULL DEFAULT '' COMMENT '风格' AFTER `material_name` ; OK

ALTER TABLE `product` CHANGE `style` `style_name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '风格'; OK

ALTER TABLE `market` ADD `batch_path_ids` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '商场首页轮播图' AFTER `site_category_2` ,
ADD `batch_path_ids_top` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '商场顶部广告图' AFTER `batch_path_ids` ; OK

ALTER TABLE `market` ADD `batch_path_ids_bottom` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '商场底部广告图' AFTER `batch_path_ids_top` ; OK

ALTER TABLE `market` ADD `introduce` VARCHAR( 400 ) NOT NULL DEFAULT '' COMMENT '商场介绍' AFTER `batch_path_ids_bottom` ,
ADD `location_txt` TEXT NOT NULL COMMENT '商场位置图' AFTER `introduce` ; OK


ALTER TABLE `market` ADD `province_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `location_txt` ,
ADD `city_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `province_id` ,
ADD `area_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `city_id` ,
ADD `txt_address` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '省 市 县' AFTER `area_id` ,
ADD `address` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '详细地址' AFTER `txt_address` ,
ADD `phone` VARCHAR( 15 ) NOT NULL DEFAULT '' COMMENT '电话' AFTER `address` ,
ADD `email` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '邮箱' AFTER `phone` ,
ADD `fax` VARCHAR( 15 ) NOT NULL DEFAULT '' COMMENT '传真' AFTER `email` ,
ADD `contacts` VARCHAR( 15 ) NOT NULL DEFAULT '' COMMENT '联系人' AFTER `fax` ;  OK



－－2016－12－26－xzp－

CREATE TABLE `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '搜索次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;OK


－－2017－1－2－xzp－
ALTER TABLE `store` ADD `favorite_num` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '收藏次数' AFTER `im_weixin` ;OK


－－2017－1－4－xzp－
CREATE TABLE `navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '栏目标题',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接',
  `content` text NOT NULL COMMENT '内容',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='店铺导航栏目'; OK


－－2017－1－5－xzp－

ALTER TABLE `postage_way` ADD `store_id` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '店铺ID' AFTER `display`; OK

ALTER TABLE `navigation` ADD `display` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '1=显示，0＝隐藏' AFTER `store_id` ; OK


ALTER TABLE `store` ADD `custom_attribute` VARCHAR( 50 ) NOT NULL DEFAULT '' COMMENT '属性设置' AFTER `favorite_num` ; OK


ALTER TABLE `store` ADD `business_scope` VARCHAR( 140 ) NOT NULL DEFAULT '' COMMENT '经营范围' AFTER `custom_attribute` ; OK

－－2017－1－6－xzp－

ALTER TABLE `store` ADD `store_type` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '意向店铺类型' AFTER `user_id` ; OK

ALTER TABLE `store` ADD `producer_auth` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '实体厂家认证：0＝未认证；1＝已认证' AFTER `store_auth` ; OK

ALTER TABLE `store` ADD `retailer_auth` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '实力电商认证：0＝未认证；1＝已认证' AFTER `producer_auth`; OK

－－2017－1－7－xzp－

ALTER TABLE `store` ADD `display_time` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '审核时间' AFTER `end_time` ;  OK

ALTER TABLE `store` ADD `admin_remark` VARCHAR( 140 ) NOT NULL DEFAULT '' COMMENT '后台备注' AFTER `close_reason` ;  OK
 
DROP TABLE IF EXISTS `theme`;

CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模板名称',
  `alias` varchar(20) NOT NULL DEFAULT '' COMMENT '模板别名',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '模板图片',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示：0＝不显示；1＝显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias_index` (`alias`),
  KEY `display_index` (`display`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='店铺模板';  OK

/*Data for the table `theme` */

insert  into `theme`(`id`,`theme_name`,`alias`,`sort`,`path`,`display`) values (1,'旺铺标准版','style1',0,'uploads/2017/0107/20170107180819705950.png',1),(2,'旺铺旗舰店','style2',0,'uploads/2017/0107/20170107181337888763.png',1);


ALTER TABLE `store_grade` ADD `theme_alias` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '店铺模板' AFTER `display` ;   OK

ALTER TABLE `store_grade` CHANGE `theme_alias` `theme_ids` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '店铺模板';  OK


－－2017－1－8－xzp－

DROP TABLE IF EXISTS `ad_store`;

CREATE TABLE `ad_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=导航栏下方广告；2＝产品展示广告',
  `path` varchar(100) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '0',
  `ad_text` varchar(100) NOT NULL DEFAULT '',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  PRIMARY KEY (`id`),
  KEY `ad_type_index` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='店铺广告位';   OK


ALTER TABLE `ad_store` ADD `url` VARCHAR( 300 ) NOT NULL DEFAULT '' COMMENT '链接' AFTER `ad_text` ; OK

－－2017－1－10－xzp－

ALTER TABLE `user` ADD `is_check_email` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '邮箱是否验证1＝已验证；0＝未验证' AFTER `wb_uid` ,
ADD `is_check_mobile` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '验证手机；1＝已验证；0＝未验证' AFTER `is_check_email` ;  OK


ALTER TABLE `comment` CHANGE `grade` `grade` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评分：1－5星';   OK

ALTER TABLE `comment` ADD `batch_path_ids` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '晒图' AFTER `display` ,
ADD `evaluate` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '1＝好评；2＝中评；3＝差评；' AFTER `batch_path_ids` ,
ADD `is_anonymous` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '匿名：1＝匿名；0＝公开' AFTER `evaluate` ;  OK

ALTER TABLE `comment` ADD `store_id` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '店铺ID' AFTER `user_id` ;   OK




DROP TABLE IF EXISTS `sms_email`;

CREATE TABLE `sms_email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `code` int(8) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) unsigned NOT NULL,
  `content` varchar(400) NOT NULL DEFAULT '' COMMENT '邮箱内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='邮箱验证验证码信息表';   OK



ALTER TABLE `user` ADD `evaluate_a` INT( 11 ) NOT NULL DEFAULT '100' COMMENT '好评数' AFTER `is_check_mobile` ,
ADD `evaluate_b` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '中评数' AFTER `evaluate_a` ,
ADD `evaluate_c` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '差评数' AFTER `evaluate_b` ; OK


ALTER TABLE `store` ADD `evaluate_a` INT( 11 ) NOT NULL DEFAULT '100' COMMENT '好评数' AFTER `business_scope` ,
ADD `evaluate_b` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '中评数' AFTER `evaluate_a` ,
ADD `evaluate_c` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '差评数' AFTER `evaluate_b` ;   OK

ALTER TABLE `store` ADD `des_grade` DECIMAL( 10, 2 ) NOT NULL DEFAULT '5' COMMENT '描述' AFTER `evaluate_c` ,
ADD ` serve_grade` DECIMAL( 10, 2 ) NOT NULL DEFAULT '5' COMMENT '服务' AFTER `des_grade` ,
ADD `express_grade` DECIMAL( 10, 2 ) NOT NULL DEFAULT '5' COMMENT '快递' AFTER ` serve_grade` ;   OK


ALTER TABLE `store` CHANGE ` serve_grade` `serve_grade` DECIMAL( 10, 2 ) NOT NULL DEFAULT '5.00' COMMENT '服务';  OK

ALTER TABLE `comment` ADD `des_grade` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '描述；最大为五星' AFTER `is_anonymous` ,
ADD `serve_grade` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '服务；最大为五星' AFTER `des_grade` ,
ADD `express_grade` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '快递；最大为五星' AFTER `serve_grade` ;   OK

ALTER TABLE `comment` ADD `des_grade` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '描述；最大为五星' AFTER `is_anonymous` ,
ADD `serve_grade` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '服务；最大为五星' AFTER `des_grade` ,
ADD `express_grade` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '快递；最大为五星' AFTER `serve_grade` ;  OK



DROP TABLE IF EXISTS `comment_store`;

CREATE TABLE `comment_store` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(100) NOT NULL DEFAULT '' COMMENT '哪个订单',
  `user_id` int(11) unsigned NOT NULL COMMENT '评价的用户',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '被评价的店铺ID',
  `add_time` int(11) unsigned DEFAULT NULL COMMENT '评价时间',
  `des_grade` tinyint(1) NOT NULL DEFAULT '0' COMMENT '描述；最大为五星',
  `serve_grade` tinyint(1) NOT NULL DEFAULT '0' COMMENT '服务；最大为五星',
  `express_grade` tinyint(1) NOT NULL DEFAULT '0' COMMENT '快递；最大为五星',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='店铺评分';  OK


ALTER TABLE `comment` DROP `des_grade` ,
DROP `serve_grade` ,
DROP `express_grade` ;   OK


ALTER TABLE `orders` ADD `is_comment_to_seller` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '商家被评论：1＝已评论；0＝未评论' AFTER `divide_store_price` ; OK
ALTER TABLE `orders` ADD `is_comment_to_user` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '买家被评论：1＝已评论；0＝未评价' AFTER `is_comment_to_seller` ; OK


ALTER TABLE `user` ADD `push_cid` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '个推用户cid' AFTER `wb_uid` ;  OK


－－2017－1－15－xzp－

ALTER TABLE `menu` ADD `brand_ids` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '关联的品牌ID' AFTER `detail_function` ;  OK

ALTER TABLE `menu` ADD `product_category_ids` VARCHAR( 200 ) NOT NULL DEFAULT '' COMMENT '关联的产品ID' AFTER `brand_ids` ;  OK


ALTER TABLE `store` ADD `logo_path` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '小Logo地址' AFTER `express_grade` ,
ADD `index_path` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '首页广告图地址' AFTER `logo_path` ;   OK

－－2017－1－16－xzp－

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;  OK


－－2017－2－22－xzp－

ALTER TABLE `postage_way` ADD `province_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `store_id` ,
ADD `city_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `province_id` ,
ADD `area_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `city_id` ,
ADD `txt_address` VARCHAR( 100 ) NOT NULL DEFAULT '''''';  OK


ALTER TABLE `postage_way` ADD `payer` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '1=自定义运费；2＝卖家承担运费；' AFTER `txt_address` ;   OK


ALTER TABLE `postage_way` ADD `charging_mode` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '1=按件数；2＝按重量；3＝按体积' AFTER `payer` ;  OK

ALTER TABLE `postage_price` ADD `start_val` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0' COMMENT '默认/首重/首件/首体积' AFTER `area` ;  OK


ALTER TABLE `postage_price` ADD `add_val` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0' COMMENT '增加/增加重量/增加件数/增加体积' AFTER `start_price` ;  OK



－－2017－3－25－xzp－
ALTER TABLE `store` ADD `auth_file_path` VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT '认证文档上传地址' AFTER `id` ; OK

ALTER TABLE `store` CHANGE `store_type` `store_type` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '意向店铺类型:1=实体商家;2=实体厂家;3=实力电商;4＝个人实名认证'; OK

ALTER TABLE `store` ADD `auth_store_type` TINYINT( 1 ) NOT NULL DEFAULT '4' COMMENT '1=实体商家;2=实体厂家;3=实力电商;4＝个人实名认证''' AFTER `store_type` ; OK


－－2017－05－08－xzp－

ALTER TABLE `product` ADD `recommend_to_store_index` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '推荐到店铺首页' AFTER `product_size_name` ; OK

－－2017－05－18－xzp－

DROP TABLE IF EXISTS `exchange`;  OK

CREATE TABLE `exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退换货用户ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '退换货用户名',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家ID',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `store_name` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `orders_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `order_num` varchar(50) NOT NULL DEFAULT '' COMMENT '退换订单编号',
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态：0＝待审核；1＝审核未通过；2＝审核通过；',
  `content` varchar(140) NOT NULL DEFAULT '' COMMENT '说明内容',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `client_remark` varchar(140) NOT NULL DEFAULT '' COMMENT '审核备注[会员看]',
  `admin_remark` varchar(140) NOT NULL DEFAULT '' COMMENT '审核备注[管理员看]',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后处理时间',
  `exchange_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=退款；1=退货退款;3=换货',
  `exchange_reason_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '退款原因ID',
  `batch_path_ids` varchar(200) NOT NULL DEFAULT '' COMMENT '凭证',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品退换货';

---2017-05-20
ALTER TABLE `financial` ADD `seller_id` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '卖方ID' AFTER `user_id`, ADD `store_id` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '店铺ID' AFTER `seller_id`; OK

CREATE TABLE `pay_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '卖方ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `total_fee` decimal(10,2) NOT NULL COMMENT '金额',
  `total_fee_give` decimal(10,2) NOT NULL COMMENT '赠送金额',
  `out_trade_no` varchar(64) NOT NULL DEFAULT '' COMMENT '商户订单号',
  `trade_no` varchar(64) NOT NULL DEFAULT '' COMMENT '支付宝交易订单号',
  `order_num` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `buyer_email` varchar(100) NOT NULL DEFAULT '' COMMENT '买家支付宝账号',
  `notify_time` int(11) NOT NULL COMMENT '通知完成时间',
  `add_time` int(11) NOT NULL COMMENT '充值时间',
  `trade_status` varchar(100) NOT NULL DEFAULT '',
  `remark` varchar(140) NOT NULL DEFAULT '' COMMENT '备注',
  `rem_time` int(11) NOT NULL DEFAULT '0' COMMENT '备注时间',
  `payment_type` enum('alipay','weixin') NOT NULL DEFAULT 'alipay' COMMENT '支付类型：支付宝；微信支付',
  `order_type` enum('orders','demand','cargo_order','recharge','orders_refund','demand_refund','cargo_order_refund','recharge_refund') NOT NULL DEFAULT 'orders' COMMENT 'orders=普通订单；cargo_order＝集运；demand＝代购；recharge＝充值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;   OK

--2017-05-27
ALTER TABLE `exchange` ADD COLUMN `orders_detail_id`  int(11) UNSIGNED NOT NULL AFTER `order_num`;   OK

--2017-06-05
ALTER TABLE `comment` ADD COLUMN `is_reply`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '回复：1＝已回复；0＝未回复' AFTER `is_anonymous`;  OK

DROP TABLE IF EXISTS `store_reply_comment`;
CREATE TABLE `store_reply_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) unsigned NOT NULL COMMENT '评论ID',
  `order_id` varchar(100) NOT NULL DEFAULT '' COMMENT '哪个订单',
  `user_id` int(11) unsigned NOT NULL COMMENT '评价的用户',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复的店铺ID',
  `add_time` int(11) unsigned DEFAULT NULL COMMENT '回复时间',
  `evaluate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '对用户评价 1=好评 2=中评 3=差评',
  `content` varchar(400) NOT NULL COMMENT '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='店铺评分';   OK


--2017-09-23-------xzp--

DROP TABLE IF EXISTS `seller_group`;  OK

CREATE TABLE `seller_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL COMMENT '部门名称',
  `permissions` text NOT NULL COMMENT '权限',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建者=商家',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `seller_group` */

insert  into `seller_group`(`id`,`group_name`,`permissions`,`user_id`) values (1,'超级管理员','menu,menu_menuList,menu_add,menu_edit,menu_delete,menu_sort,content,store,store_index,store_add,store_edit,store_delete,live,live_index,live_add,live_edit,live_delete,market,market_index,market_add,market_edit,market_delete,news,news_index,news_add,news_edit,news_delete,page,page_index,page_add,page_edit,page_delete,product,product_index,product_add,product_edit,product_delete,link,link_index,link_add,link_edit,link_delete,user_g,user,user_index,user_add,user_edit,user_delete,usergroup,usergroup_index,usergroup_add,usergroup_edit,usergroup_delete,admin_g,admin,admin_index,admin_add,admin_edit,admin_delete,admin_group,admin_group_index,admin_group_add,admin_group_edit,admin_group_delete,html,html_index,ad_g,ad,ad_index,ad_add,ad_edit,ad_delete,ad_sort,adgroup,adgroup_index,adgroup_add,adgroup_edit,adgroup_delete,system,system_save,watermark_save,system_wf,backup,backup_index,backup_optimize,backup_repair,backup_backupDatabase,file,file_index,file_deleteFile,systemloginlog,systemloginlog_index,pattern_index',0),(2,'业务部','ad_g,ad,ad_index,ad_add,ad_edit,ad_delete,ad_sort,adgroup,adgroup_index,adgroup_add,adgroup_edit,adgroup_delete',0);



ALTER TABLE `user` ADD `seller_group_id` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '卖家部门id' AFTER `user_group_id` ;  OK


----2018-01-13----sxh---
ALTER TABLE `product`
ADD COLUMN `unclear_price`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '到店咨询价格' AFTER `sell_price`;  OK


----2018-01-15----sxh---
ALTER TABLE `store`
ADD COLUMN `contact_num`  varchar(20) NOT NULL DEFAULT '' AFTER `index_path`; OK

ALTER TABLE `store`
ADD COLUMN `work_time`  varchar(20) NOT NULL DEFAULT '' AFTER `contact_num`;  OK



----2018-04-19----sxh---
ALTER TABLE `theme`
ADD COLUMN `ad1_size`  varchar(20) NOT NULL DEFAULT '' AFTER `display`,
ADD COLUMN `ad2_size`  varchar(20) NOT NULL DEFAULT '' AFTER `ad1_size`; OK

UPDATE `theme` SET ad1_size = '1200px*500px', ad2_size = '580px*580px' WHERE id = '1';   OK
UPDATE `theme` SET ad1_size = '1920px*700px', ad2_size = '1200px*500px' WHERE id = '2';  OK
UPDATE `theme` SET ad1_size = '1200px*300px', ad2_size = '580px*580px' WHERE id = '3';   OK
UPDATE `theme` SET ad1_size = '1200px*300px', ad2_size = '580px*580px' WHERE id = '4';   OK
UPDATE `theme` SET ad1_size = '1920px*550px', ad2_size = '1200px*420px' WHERE id = '5';  OK
UPDATE `theme` SET ad1_size = '1920px*700px', ad2_size = '1200px*500px' WHERE id = '6';  OK

ALTER TABLE `store`
ADD COLUMN `list_path_logo`  varchar(255) NOT NULL DEFAULT '' COMMENT '店铺首页logo' AFTER `path`;    OK


----2018-04-20----sxh---
ALTER TABLE `store`
ADD COLUMN `id_card_path_1`  varchar(255) NOT NULL DEFAULT '' COMMENT '身份证正面' AFTER `work_time`,
ADD COLUMN `id_card_path_2`  varchar(255) NOT NULL DEFAULT '' COMMENT '身份证反面' AFTER `id_card_path_1`,
ADD COLUMN `license_path`  varchar(255) NOT NULL DEFAULT '' COMMENT '营业执照' AFTER `id_card_path_2`;  OK

ALTER TABLE `product`
ADD COLUMN `is_promise`  tinyint(1) NOT NULL AFTER `recommend_to_store_index`,
ADD COLUMN `service_options`  varchar(20) NOT NULL DEFAULT '' AFTER `is_promise`;  OK

ALTER TABLE `product`
MODIFY COLUMN `is_promise`  tinyint(1) NOT NULL COMMENT '商家承诺' AFTER `recommend_to_store_index`,
MODIFY COLUMN `service_options`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '服务选项' AFTER `is_promise`;  OK


----2018-05-03----sxh---

ALTER TABLE `user`
ADD COLUMN `is_id_card_auth`  tinyint(1) NOT NULL COMMENT '实名认证' AFTER `is_check_mobile`;

ALTER TABLE `user`
ADD COLUMN `id_card`  varchar(18) NOT NULL DEFAULT '' AFTER `is_check_mobile`;



----2018-05-14----sxh---
ALTER TABLE `ad`
ADD COLUMN `app_url`  varchar(200) NOT NULL DEFAULT '' AFTER `path`;





----2018-05-22----zzg---

INSERT INTO `ad_group` VALUES (28, '招商采购频道banner[1920x470][背景大图]'); OK

----2018-05--26----sxh---
ALTER TABLE `product`
ADD COLUMN `reduced_price`  decimal(10,2) NOT NULL COMMENT '满免金额' AFTER `service_options`;


----2018-06--07----sxh---
ALTER TABLE `store`
ADD COLUMN `reg_num`  varchar(15) NOT NULL DEFAULT '' COMMENT '注册号' AFTER `license_path`,
ADD COLUMN `license_store_name`  varchar(30) NOT NULL DEFAULT '' COMMENT '营业执照名称' AFTER `reg_num`,
ADD COLUMN `license_username`  varchar(10) NOT NULL DEFAULT '' COMMENT '经营者姓名' AFTER `license_store_name`,
ADD COLUMN `license_form`  varchar(10) NOT NULL DEFAULT '' COMMENT '组成形式' AFTER `license_username`,
ADD COLUMN `license_place`  varchar(30) NOT NULL DEFAULT '' COMMENT '经营场所' AFTER `license_form`;


ALTER TABLE `store`
ADD COLUMN `license_credit_code`  varchar(18) NOT NULL DEFAULT '' COMMENT '统一社会信用代码' AFTER `license_place`,
ADD COLUMN `license_store_type`  varchar(30) NOT NULL DEFAULT '' COMMENT '企业类型' AFTER `license_credit_code`,
ADD COLUMN `license_residence`  varchar(50) NOT NULL DEFAULT '' COMMENT '住所' AFTER `license_store_type`,
ADD COLUMN `license_representative`  varchar(20) NOT NULL DEFAULT '' COMMENT '法定代表人' AFTER `license_residence`,
ADD COLUMN `license_capital`  varchar(20) NOT NULL DEFAULT '' COMMENT '注册资本' AFTER `license_representative`,
ADD COLUMN `license_made_time`  varchar(20) NOT NULL DEFAULT '' COMMENT '成立日期' AFTER `license_capital`,
ADD COLUMN `license_time_limit`  varchar(30) NOT NULL DEFAULT '' COMMENT '营业期限' AFTER `license_made_time`;
ALTER TABLE `store`
ADD COLUMN `license_business_scope`  varchar(255) NOT NULL DEFAULT '' COMMENT '经营范围' AFTER `license_time_limit`;




----2018-06--27----zzg---

ALTER TABLE `yiliwang`.`ad`
ADD COLUMN `xcx_url` varchar(255) NOT NULL AFTER `path`;

ALTER TABLE `yiliwang`.`ad_store`
ADD COLUMN `xcx_url` varchar(255) NOT NULL COMMENT 'xcx链接' AFTER `store_id`,
ADD COLUMN `app_url` varchar(255) NOT NULL AFTER `xcx_url`;

ALTER TABLE `yiliwang`.`store`
ADD COLUMN `app_banner` varchar(255) NOT NULL COMMENT 'app小程序banner图' AFTER `store_banner`;


----2018-07--09----sxh---
ALTER TABLE `store`
ADD COLUMN `market_id`  int(11) NOT NULL AFTER `owner_card`;

----2018-07--18----sxh---
DROP TABLE IF EXISTS `fabric`;
CREATE TABLE `fabric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fabric_name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '类别',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID：0＝官方分类；其它代表店铺申请的',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示：0＝不显示；1＝显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='面料列表';


DROP TABLE IF EXISTS `leather`;
CREATE TABLE `leather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leather_name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '类别',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID：0＝官方分类；其它代表店铺申请的',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示：0＝不显示；1＝显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='皮革列表';

DROP TABLE IF EXISTS `filler`;
CREATE TABLE `filler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filler_name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '类别',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID：0＝官方分类；其它代表店铺申请的',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示：0＝不显示；1＝显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='填充物列表';



----2018-07--18----zzg---

ALTER TABLE `yiliwang`.`product` 
ADD COLUMN `fabric_name` varchar(50) NOT NULL COMMENT '面料' AFTER `material_name`,
ADD COLUMN `leather_name` varchar(50) NOT NULL COMMENT '皮革' AFTER `fabric_name`,
ADD COLUMN `filler_name` varchar(50) NOT NULL COMMENT '填充物' AFTER `leather_name`;  OK




----2018-07--26----sxh---
ALTER TABLE `promotion_ptkj`
CHANGE COLUMN `name` `deposit`  decimal(10,2) NOT NULL COMMENT '保证金' AFTER `id`,
ADD COLUMN `min_number`  int(11) NOT NULL COMMENT '最少团购人数' AFTER `path`,
ADD COLUMN `max_number`  int(11) NOT NULL COMMENT '最多团购人数' AFTER `min_number`,
ADD COLUMN `type`  tinyint(1) NULL COMMENT '团购方式' AFTER `max_number`;

ALTER TABLE `promotion_ptkj`
MODIFY COLUMN `type`  tinyint(1) NOT NULL COMMENT '团购方式' AFTER `max_number`,
ADD COLUMN `sale_price`  decimal(10,2) NOT NULL COMMENT '固定团购价' AFTER `type`;

ALTER TABLE `ptkj_record`
ADD COLUMN `is_bond`  tinyint(1) NOT NULL COMMENT '是否支付保证金' AFTER `size_id`;

ALTER TABLE `promotion_ptkj`
ADD COLUMN `delivery_time`  int(11) NOT NULL COMMENT '发货时间' AFTER `sale_price`,
ADD COLUMN `success_time`  int(11) NOT NULL COMMENT '成团时间' AFTER `delivery_time`,
ADD COLUMN `is_success`  tinyint(1) NOT NULL COMMENT '是否成团' AFTER `success_time`;

ALTER TABLE `ptkj_record`
ADD COLUMN `bond_number`  varchar(25) NOT NULL COMMENT '支付定金订单号' AFTER `is_bond`,
ADD COLUMN `trade_no`  varchar(64) NOT NULL COMMENT '支付宝交易号' AFTER `bond_number`;

ALTER TABLE `pay_log`
MODIFY COLUMN `order_type`  enum('orders','groupon','recharge','orders_refund','groupon_refund','recharge_refund') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'orders' COMMENT 'orders=普通订单；groupon＝团预购；recharge＝充值' AFTER `payment_type`;

ALTER TABLE `ptkj_record`
ADD COLUMN `store_id`  int(11) NOT NULL AFTER `ptkj_id`,
ADD COLUMN `seller_id`  int(11) NOT NULL AFTER `store_id`;

ALTER TABLE `ptkj_record`
ADD COLUMN `payment_id`  int(11) NOT NULL AFTER `trade_no`;

ALTER TABLE `orders`
ADD COLUMN `order_type`  tinyint(1) NOT NULL COMMENT '订单类型 1=团预购' AFTER `is_comment_to_user`;

ALTER TABLE `orders`
ADD COLUMN `groupon_id`  int(11) NOT NULL COMMENT '活动id' AFTER `order_type`;  OK


----2018--08--30---sxh--

ALTER TABLE `orders`
ADD COLUMN `deposit`  decimal(10,2) NOT NULL AFTER `discount_total`;

ALTER TABLE `promotion_ptkj`
ADD COLUMN `store_id`  int(11) NOT NULL AFTER `is_success`;

ALTER TABLE `ptkj_record`
ADD COLUMN `is_refund`  tinyint(1) NOT NULL AFTER `payment_id`;



