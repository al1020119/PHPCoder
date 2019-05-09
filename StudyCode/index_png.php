<?php
    // //图片地址
    // $file = 'http://zixuephp.net/static/images/php.png';
    // //旋转角度
    // $angle = 90;
    // //判断图片是否能加载
    // if(file_get_contents($file)){
    //     $name = '';
    //     //生成图片名
    //     $name = time().rand(0,9).rand(0,9);
    //     //获取图片信息
    //     $info = getimagesize($file);
    //     //获取图片类型
    //     $mime = $info['mime'];
     
    //     //各格式图片资源的载入、旋转、保存
    //     if($mime == 'image/png'){
    //         $source = imagecreatefrompng($file);
    //         imagepng(imagerotate($source, $angle, 0),$name.'.png');
    //         echo "新图片地址：".$name.'.png';
    //     }else if($mime == 'image/jpeg'){
    //         $source = imagecreatefromjpeg($file);
    //         imagejpeg(imagerotate($source, $angle, 0),$name.'.jpg');
    //         echo "新图片地址：".$name.'.jpg';
    //     }else if($mime == 'image/gif'){
    //         $source = imagecreatefromgif($file);
    //         imagegif(imagerotate($source, $angle, 0),$name.'.gif');
    //         echo "新图片地址：".$name.'.gif';
    //     }else if($mime == 'image/bmp'){
    //         $source = imagecreatefromwbmp($file);
    //         imagewbmp(imagerotate($source, $angle, 0),$name.'.bmp');
    //         echo "新图片地址：".$name.'.bmp';
    //     }else{
    //         $source = imagecreatefromjpeg($file);
    //         imagejpeg(imagerotate($source, $angle, 0),$name.'.jpg');
    //         echo "新图片地址：".$name.'.jpg';
    //     }
     
    // }else{
    //     echo '图片加载失败';
    // }

$a = array(0 => Array('a' => 1,'b' => array('z' => 'aa','x'=>10)));
$b = array(0 => Array('a' => 2));
$c = array('a' =>'test');
$d = array('a' =>'test1');
var_dump(array_merge($a,$b,$c,$d));
var_dump(array_merge_recursive($a,$b,$c,$d));
var_dump($c = $a+$b+$c+$d)

?>