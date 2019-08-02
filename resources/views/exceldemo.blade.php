<?php 
header("Content-type:application/vnd.ms-excel"); 
header("Content-Disposition:filename=xls_region.xls"); 
$cfg_dbhost = 'localhost'; 
$cfg_dbname = 'testdb'; 
$cfg_dbuser = 'root'; 
$cfg_dbpwd = 'root'; 
$cfg_db_language = 'utf8'; 
// END 配置 
//連結資料庫 
$link = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd); 
mysql_select_db($cfg_dbname); 
//選擇編碼 
mysql_query("set names ".$cfg_db_language); 
//users表 
$sql = "desc users"; 
$res = mysql_query($sql); 
echo "<table><tr>"; 
//匯出表頭(也就是表中擁有的欄位) 
while($row = mysql_fetch_array($res))
    { $t_field[] = $row['Field']; //Field中的F要大寫,否則沒有結果 
    echo "<th>".$row['Field']."</th>"; } 
    echo "</tr>"; 
//匯出100條資料 
$sql = "select * from users limit 100"; 
$res = mysql_query($sql); 
while($row = mysql_fetch_array($res))
    { echo "<tr>"; 
    foreach($t_field as $f_key)
    { echo "<td>".$row[$f_key]."</td>"; } echo "</tr>"; } echo "</table>";
?>