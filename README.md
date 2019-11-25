# dataDictionary
PHP生成数据库数据字典（PHP generates a database data dictionary）
##使用说明：
1.打开config.php，配置数据库连接参数即可.
//配置项
return array(
    //数据库类型
    'database_type' => 'mysql',
	
	//数据库名称
    'database_name' => 'cpj',
	
	//host
    'server' => 'localhost',
	
	//数据库用户名
    'username' => 'root',
	
	//数据库密码
    'password' => 'root',
	
	//数据库编码格式
    'charset' => 'utf8'
);
1.运行项目：http://localhost//dataDictionary/index.php
1.数据字典效果：
<p align="center">
<img src="https://raw.githubusercontent.com/leadtodream/dataDictionary/master/demo.png" alt="License">
</p>