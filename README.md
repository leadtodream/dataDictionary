# dataDictionary
PHP生成数据库数据字典（PHP generates a database data dictionary）
##使用说明：
<p align="left">
1.打开config.php，配置数据库连接参数即可.
//配置项
<pre>
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
</pre>
</p>
<p align="left">2.运行项目：http://localhost//dataDictionary/index.php</p>
<p align="left">3.数据字典效果：</p>
<p align="center">
<img src="https://raw.githubusercontent.com/leadtodream/dataDictionary/master/demo.png" alt="License">
</p>