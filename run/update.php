<?php
include_once __DIR__.'/MySQL.php';
$dbconfig=require __DIR__.'/../public/dbconfig.php';
echo "- выполняется скрипт обновления структуры БД и файлов\n";
echo "- закончено\n";
$sqln=new MySQL();
$sqln->connect($dbconfig['host'],$dbconfig['username'],$dbconfig['password'],$dbconfig['basename']);  
if ($sqln->idsqlconnection->connect_error!="") {die("----ОШИБКА УСТАНОВКИ СОЕДИНЕНИЯ С БД. Настройте public/dbconfig.php\n");};
echo "--Ok\n";
echo "--Узнаем текущую версию БД\n";
$ver=GetByParam($sqln,'core_version');
if ($ver==""){
  die("--- чтото не так со структурой БД. Не удалось определить core_version\n");  
};
echo "--Ok : $ver\n";
echo "--Обновляю структуру БД\n";
echo "--работа завершена!\n";
function GetByParam($sqlcn,$nameparam){
    $resz = "";
    $result = $sqlcn->ExecuteSQL("SELECT * FROM config WHERE name='$nameparam'") or $err[]="Неверный запрос GetByParam:".mysqli_error($sqlcn->idsqlconnection);
    while ($myrow = mysqli_fetch_array($result)) {
        $resz = $myrow['value'];
    }
    return $resz;
}