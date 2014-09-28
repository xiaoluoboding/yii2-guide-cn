<?php
//1、获取基数（从我们的计算机中获取）
//2、把取出的文件数加1；
//3、把新的数据写入到计数文件
//产生资源句柄
$countfile=fopen(__DIR__ . "\count.txt","r");
$count=fread($countfile,100); //读取计数文件的数据
$count++;//基数+1
//重新产生新的句柄
$countfile2=fopen(__DIR__ . "\count.txt","w");
//写入文件
fwrite($countfile2,$count);
//关闭句柄，释放资源
fclose($countfile);
?>