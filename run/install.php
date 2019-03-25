<?php
chdir(dirname(__DIR__));
include_once __DIR__.'/MySQL.php';
$dbconfig=require __DIR__.'/../public/dbconfig.php';
echo "- выполняется скрипт заполнения структуры БД и настройки конфигурации\n";
echo "--соединяюсь с БД MySQL\n";
$sqln=new MySQL();
$sqln->connect($dbconfig['host'],$dbconfig['username'],$dbconfig['password'],$dbconfig['basename']);  
if ($sqln->idsqlconnection->connect_error!="") {die("----ОШИБКА УСТАНОВКИ СОЕДИНЕНИЯ С БД. Настройте public/dbconfig.php\n");};
echo "--Ok\n";
echo "--Заливаю в БД дамп базы webuseorg4.sql\n";
$handle = file_get_contents(__DIR__.'/webuseorg4.sql', 'r');
if ($handle == false) {
	echo "----Ошибка открытия файла: webuseorg4.sql\n";
	die();
};
if (mysqli_multi_query($sqln->idsqlconnection, $handle)) {
    do {
        if ($result = mysqli_store_result($sqln->idsqlconnection)) {
            mysqli_free_result($result);
        }
        if (mysqli_more_results($sqln->idsqlconnection)) {

        }        
    } while (mysqli_next_result($sqln->idsqlconnection));
}
echo "--Ok\n";
echo "- закончено\n";

