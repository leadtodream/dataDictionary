# dataDictionary
PHP生成数据库数据字典（PHP generates a database data dictionary）
## 支持数据库类型

- mysql
- oracle
- mssql
- db2
- PostgreSQL
- Sybase 
- SQLite
- MariaDB
- 备注:需开启对应数据库的pdo扩展

## PHP环境需求
- PHP >= 5.4

##使用说明：
<p align="left">
1.打开config.php，配置数据库连接参数即可.</p>
<pre>
//配置项
return array(
	'db' => array(
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
	),
	'type'=>'create',//下载类型table:表格型字典(xls)，create：创建语句(txt)
);
</pre>
<p align="left">2.运行项目：http://localhost//dataDictionary/index.php</p>
<p align="left">3.生成的数据字典效果如下图：</p>
<p align="center">
<img src="https://raw.githubusercontent.com/leadtodream/dataDictionary/master/demo.png" alt="License">
</p>