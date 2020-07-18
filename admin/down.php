<?php
$url = "https://github.com/unkaer/olvideo/archive/master.zip";  // 下载地址
$file = "./olvideo.zip";  // 下载压缩包，存放位置
$dirsrc = "olvideo-master";  // 解压后目录
$dirto = "..";  // 覆盖安装目录
if($_GET['id']=='1'){
// 下载最新版系统
$html = file_get_contents($url);
file_put_contents($file,$html);
echo "下载成功";
}
// 解压文件
if($_GET['id']=='2'){
$zip = new ZipArchive() ; 
if ($zip->open($file) !== TRUE) { 
  die ("打开压缩文件失败"); 
} 
//将压缩文件解压到指定的目录下 
$zip->extractTo('./'); 
//关闭zip文档 
$zip->close();
echo '解压成功'; 
unlink($file); //删除压缩文件
}

if($_GET['id']=='3'){
function copydir($dirsrc, $dirto) {
//如果原来的文件存在， 判断是不是一个目录
    if(file_exists($dirto)) {
        if(!is_dir($dirto)) {
        echo "目标不是一个目录， 不能copy进去<br>";
        exit;
        }
    }
    else{
        mkdir($dirto);
    }
    $dir = opendir($dirsrc);
    while($filename = readdir($dir)) {
        if($filename != "." && $filename !="..") {
            $srcfile = $dirsrc."/".$filename; //原文件
            $tofile = $dirto."/".$filename; //目标文件
            if(is_dir($srcfile)) {
            if(copydir($srcfile, $tofile))echo "成功拷贝目录：$srcfile--->$tofile<br/>\n"; //递归处理所有子目录
            }
            else{
            //是文件就拷贝到目标目录
            if(copy($srcfile, $tofile))echo "成功拷贝文件：$srcfile--->$tofile<br/>\n";
            }
        }
    }
}
echo "<p>拷贝文件夹:</p>";
if(!is_dir($dirsrc)){
    echo $dirsrc."文件目录不存在";
    exit;
}
copydir($dirsrc, $dirto);


//循环删除目录和文件函数
function delDirAndFile($dirName){ 
    if ($handle=opendir($dirName)){
        while(false!==($item=readdir($handle))){
            if($item!="."&&$item!=".."){
                if(is_dir("$dirName/$item")){
                    delDirAndFile("$dirName/$item");
                }
                else{
                    if(unlink("$dirName/$item"))echo "成功删除文件：$dirName/$item<br/>\n";
                }
            }
        }
        closedir($handle);
        if(rmdir($dirName))echo "成功删除目录：$dirName<br/>\n"; 
    }
} 
echo "<p>删除旧目录:</p>";
delDirAndFile("olvideo-master");  // 删除旧目录

}

?>