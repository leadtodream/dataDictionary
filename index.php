<?php
// +----------------------------------------------------------------------+
// |  PHP 生成数据库字典                                                  |
// +----------------------------------------------------------------------+
// | Author: @nsy 2019-11-25                                              |
// +----------------------------------------------------------------------+
header("Content-type:text/html;charset=utf-8;");
require_once 'Medoo.php';
//配置项
$database_name = 'cpj';//数据库名称
$config =  array(
	'database_type' => 'mysql',//数据库类型
    'database_name' => $database_name,
    'server' => 'localhost',//host
    'username' => 'root',//数据库用户名
    'password' => 'root',//数据库密码
    'charset' => 'utf8'//数据库编码格式
);
//实例并初始化Medoo对象
$database = new Medoo\Medoo($config);
//列出数据库下，所有的表名
$tables = $database->query(
	"show tables"
)->fetchAll();
if(!$tables){
	exit("暂无数据表！");
}

//循环组装数据
$int_key = 0;
$str_key = 'Tables_in_'.$database_name;
//存放结果集
$result = array();
foreach($tables as $key => $items){
	/*[Tables_in_cpj] => im_sns_base
	[0] => im_sns_base*/
	//取出数据表备注信息
	$sql  = "SELECT TABLE_COMMENT,TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE ";
    $sql .= "table_name = '{$items[$int_key]}' AND table_schema = '{$database_name}'";
	$table_content = $database->query($sql)->fetchAll();
	
	//获取表字段信息
	$sql = "SELECT * FROM  INFORMATION_SCHEMA.COLUMNS  WHERE  table_name = '{$items[$int_key]}' AND table_schema = '{$database_name}'";
	$table_columns = $database->query($sql)->fetchAll();
	$result[] =  array(
		'table_content' => $table_content,
		'table_columns' => $table_columns
	);
}

//表头
$header = array(
	"字段",	
	'类型',
	'是否为空',
	'描述'
);
$head_txt = "<tr>";
foreach ($header as $v) {
	$head_txt .= "<td>$v</td>";
}
$head_txt .= "</tr>";
//导出文件名
$file_name = $database_name."数据字典.xls";
$html = '';
foreach($result as $kk => $val){
	$data = array();
	//封装导出数据实体
	$table_content = $val['table_content'][0][0];
	!$table_content && $table_content = $val['table_content'][0][1];
	foreach($val['table_columns'] as $vl){
		$data[] = array(
			'COLUMN_NAME'=>$vl['COLUMN_NAME'],
			'COLUMN_TYPE'=>$vl['COLUMN_TYPE'],
			'IS_NULLABLE'=>$vl['COLUMN_KEY']?$vl['COLUMN_KEY']:$vl['IS_NULLABLE'],
			'COLUMN_COMMENT'=>$vl['COLUMN_COMMENT']?$vl['COLUMN_COMMENT']:$vl['COLUMN_NAME'],
		);
	}
	//组装实体数据部分
	$html .='<b>'.$val['table_content'][0][1]."</b>({$table_content}):<br/>";
	$html .="<table border=1>" . $head_txt;
	$html .= '';
	foreach ($data as $key => $rt) {
		$html .= "<tr>";
		foreach ($rt as $v) {
			$html .= "<td >{$v}</td>";
		}
		$html .= "</tr>\n";
	}
	$html .= "</table><br/>";
}
$html = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>".$html.'</body></html>';
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $file_name);
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
header("Expires: 0");
exit($html);
?>