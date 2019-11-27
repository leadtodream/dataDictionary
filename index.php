<?php
// +----------------------------------------------------------------------+
// |  PHP 生成数据库字典                                                  |
// +----------------------------------------------------------------------+
// | Author: @nsy 2019-11-25                                              |
// +----------------------------------------------------------------------+
header("Content-type:text/html;charset=utf-8;");
require_once 'includes/Medoo.php';
$config = require_once 'config.php';
$db = $config['db'];
$type = $config['type'];
unset($config);
//数据库名称,这里单独取出来以备下文使用
$database_name = $db['database_name'];
//实例并初始化Medoo对象
try{
	$database = new Medoo\Medoo($db);
}catch (Exception $e){
	die($e->getMessage());
}
//列出数据库下，所有的表名
$tables = $database->query(
	"show tables"
)->fetchAll();
if(!$tables){
	exit("暂无数据表！");
}

$int_key = 0;
//$str_key = 'Tables_in_'.$database_name;
//存放结果集
$result = array();
$sql_txt = '';
foreach($tables as $key => $items){
	if($type=='create'){
		$create_sql = "show create table {$items[$int_key]}";
		$ret = $database->query($create_sql)->fetchAll();
		$sql_txt .= $ret[0][1]."\r\n\n";
	}else{
		/*[Tables_in_cpj] => im_sns_base
		[0] => im_sns_base*/
		//取出数据表备注信息
		$sql  = "SELECT TABLE_COMMENT,TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE ";
		$sql .= "table_name = '{$items[$int_key]}' AND table_schema = '{$database_name}'";
		$table_content = $database->query($sql)->fetchAll();
		//获取表字段信息
		$sql = "SELECT * FROM  INFORMATION_SCHEMA.COLUMNS  WHERE  table_name = '{$items[$int_key]}' AND table_schema = '{$database_name}'";
		$table_columns = $database->query($sql)->fetchAll();
		//组装数据
		$result[] =  array(
			'table_content' => $table_content,
			'table_columns' => $table_columns
		);
	}
}
//txt下载
if($type=='create'){
	header("Content-type:application/txt");
	header("Content-Disposition: attachment;filename={$database_name}数据字典.txt");
	exit($sql_txt);
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
//数据实体
$html = '';
foreach($result as $kk => $val){
	$data = array();
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