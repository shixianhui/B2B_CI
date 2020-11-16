安装方法:
一、首先配置好php环境:
二、创建数据库：
数据引擎建议支持InnoDB, 创建一个char_set="utf8",dbcollat="utf8_general_ci"的数据库,
导入"application/admin/config/sql/init.sql"
三、配置数据库连接：
后台：打开"application/admin/config/database.php"文件进行配置
前台：打开"application/client/config/database.php"文件进行配置
四、配置网站访问地址：
后台：打开"application/admin/config/config.php"文件，对$config['base_url']进行配置
前台：打开"application/client/config/config.php"文件进行配置，对$config['base_url']进行配置
五：文件访问路径配置：
后台:打开根目录下的"admincp.php"进行配置
前台:打开根目录下的"index.php"进行配置
六：编辑文件上传目录配置：
ckfinder2.1/config.php
$baseUrl = '/upfiles/';//以根目录为准
CheckAuthentication()方法现在是直接返回true,最好是写些条件,对企业站问题应该不大，安全性要求高的一定要写条件


注：高级的配置可以参照ci用户手册进行