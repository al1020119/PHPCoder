<?php
 
use service\DataService;
use service\NodeService;
use think\Db;
 
 
/**
 * 日期格式标准输出
 * @param string $datetime 输入日期
 * @param string $format 输出格式
 * @return false|string
 */
function format_datetime($datetime, $format = 'Y年m月d日 H:i:s')
{
    return date($format, strtotime($datetime));
}
 
/**
 * UTF8字符串加密
 * @param string $string
 * @return string
 */
function encode($string)
{
    list($chars, $length) = ['', strlen($string = iconv('utf-8', 'gbk', $string))];
    for ($i = 0; $i < $length; $i++) {
        $chars .= str_pad(base_convert(ord($string[$i]), 10, 36), 2, 0, 0);
    }
    return $chars;
}
 
/**
 * UTF8字符串解密
 * @param string $string
 * @return string
 */
function decode($string)
{
    $chars = '';
    foreach (str_split($string, 2) as $char) {
        $chars .= chr(intval(base_convert($char, 36, 10)));
    }
    return iconv('gbk', 'utf-8', $chars);
}
 
/**
 * description：获取某张表的字段
 * author：wanghua
 * @param $tablename
 * @return array
 */
function getTableFieldsByName($tablename){
    if(!$tablename)return [];
    $prefix = config('database.prefix');
    if($prefix && false !== strpos($tablename, $prefix))
        $tablename = $prefix.$tablename;
 
    return Db::table($tablename)->getTableFields();
}
 
/**
 * description：换行输出（一般用于调试 eg：在循环中输出）
 * author：wanghua
 */
function brEcho($msg){
    echo '<br/>';
    echo $msg;
    echo '<br/>';
}
 
/**
 * description：常用表单类型 1 input 2 select 3 radio 4 textarea 5 textarea_editer 6 img
 * author：wanghua
 * @param string $type
 * @param bool|false $all
 * @return array|string
 */
function getFormType($type='', $all=false){
    $arr = ['','input','date','select','radio','textarea','textarea_editer', 'img'];
    if($type){
        if(is_numeric($type)){
            return isset($arr[$type])?$arr[$type]:$type;
        }else{
            return $type;
        }
    }
    if($all){
        return $arr;
    }
    return '';
}
 
/**
 * description：根据下标获取字段类型（常用且可配置）
 * author：wh
 */
function getFieldsType($type='', $all=false){
    $arr = ['','int','float','varchar','text','longtext'];
 
    if($type){
        return empty($arr[$type])?$type:$arr[$type];
    }
    if($all){
        return $arr;
    }
    return $type;
}
 
/**
 * description：网站菜单列表（这里只是例子）
 * author：wh
 * @param $type 下标值
 * @param string $all 返回所有
 * @return array
 */
function getMenuType($type, $all=''){
    $arr = [
        1=>'首页',
        2=>'关于我们',
        3=>'课程设置',
        4=>'招生信息',
        5=>'师资队伍',
        6=>'优秀学生',
        7=>'新闻资讯',
        8=>'联系我们'
    ];
    if($type){
        return empty($arr[$type])?$type:$arr[$type];
    }
    if($all){
        return $arr;
    }
    return $type;
}
 
/**
 * description：读取base64编码后的图片并保存到path（实测可用）
 * author：wh
 * @param $base64_image_content
 * @param $path
 * @return bool|string
 */
function base64_image_content($base64_image_content,$path){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path."/".date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0777);
        }
        $new_file = $new_file.time().".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return '/'.$new_file;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
 
/**
 * 验证手机号是否正确（常规）
 * @author wanghua
 */
function is_mobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,3,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
}
 
/**
 * description：查询当前数据库所有的表名
 * author：wh
 * @return mixed 返回表名一维数组
 */
function getTables(){
    return array_column(Db::query('SHOW TABLES;'), 'Tables_in_'.config('database.database'));
}
 
/**
 * description：获取项目根路径
 * author：wanghua
 */
if (!function_exists('get_root_path')) {
    function get_root_path(){
        $str = str_replace('\\', '/', APP_PATH);
        return $str.'..';
    }
}
/**
 * 验证邮箱格式（常规）
 */
function is_email($email){
   return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)?true:false;
}
 
/**
 * description：删除目录下的文件：权限不足可能导致失败
 * author：wanghua
 * @param $backpath
 * @return bool
 */
function deleteFile($path=''){
    if(!$path|| !file_exists($path))return false;
    $files = scandir($path);
    if($files){
        foreach ($files as $key => $val){
            if(!in_array($val, ['.', '..'])){
                unlink($path.$val);
            }
        }
        return true;
    }else{
        return false;
    }
}
 
if(!function_exists('log_to_write_txt')){
    /**
     * 记录日志文本到.txt文件-日志文件可即时删除
     * wanghua
     * @param string $data
     * @param string $filepath 默认保存路径
     */
    function log_to_write_txt($data = 'test', $filepath = '/runtime/log.txt'){
        //IP白名单-正式运营后可开启
        //$white_ips = [
        //    '183.67.48.137'
        //];
        //if(in_array(get_client_ip(), $white_ips)){
        $filepath = get_root_path().$filepath;
        $str = '';
        file_put_contents($filepath, is_object($data)||is_array($data)?$str.json_encode($data)."\n":$str.$data."\n", FILE_APPEND);
        //}else{
        //    file_put_contents($filepath, 'white_ips have not check success '."\n", FILE_APPEND);
        //}
    }
}
/**
 * description：二维对象数组转换为二维数组
 * author：wanghua
 */
 
if (!function_exists('objToArray')) {
    function objToArray($peoples){
        $tmp = [];
        foreach ($peoples as $k=>$v){
            $tmp[$k] = is_object($v)?$v->toArray():$v;
        }
        return $tmp;
    }
}
 
//将XML字符串转为array
if (!function_exists('xmlStrToArray')) {
    function xmlStrToArray($xml){
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
}
 
/**
 * description：产生一个订单号
 * 说明：userid一般是定长
 * author：wanghua
 */
if (!function_exists('createOrderNo')) {
    function createOrderNo(){
        return time().session('user.userid').rand(10000,99999);
    }
}
 
/**
 * 输出xml字符
 * @throws WxPayException
 **/
if (!function_exists('toXml')) {
    function toXml($data){
        if(!is_array($data) || count($data) <= 0){
            throw new WxPayException("数组数据异常！");
        }
 
        $xml = "<xml>";
        foreach ($data as $key=>$val){
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}
/**
 * description：返回xml 对象
 * author：wanghua
 * @param bool $res
 * @return string
 */
if (!function_exists('xmlResReturn')) {
    function xmlResReturn($res = true){
        $tmp_suc = $res?'SUCCESS':'FAIL';
        $tmp_ok = $res?'OK':'ERR';
        $xml = "<xml>
                      <return_code><![CDATA[{$tmp_suc}]]></return_code>
                      <return_msg><![CDATA[{$tmp_ok}]]></return_msg>
                    </xml>";
 
        return simplexml_load_string($xml);
    }
}
 
/**
 * XML编码
 * @param mixed $data 数据
 * @param string $encoding 数据编码
 * @param string $root 根节点名
 * @return string
 */
if (!function_exists('xml_encode')) {
    function xml_encode($data, $encoding='utf-8', $root='xml') {
        $xml    = '<?xml version="1.0" encoding="' . $encoding . '"?>';
        $xml   .= '<' . $root . '>';
        $xml   .= data_to_xml($data);
        $xml   .= '</' . $root . '>';
        return $xml;
    }
}
 
/**
 * 数据XML编码
 * @param mixed $data 数据
 * @return string
 */
if (!function_exists('data_to_xml')) {
    function data_to_xml($data) {
        $xml = '';
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml    .=  "<$key>";
            $xml    .=  ( is_array($val) || is_object($val)) ? data_to_xml($val) : $val;
            list($key, ) = explode(' ', $key);
            $xml    .=  "</$key>";
        }
        return $xml;
    }
}
 
/**
 * description：设置结果（常用于异步请求返回格式）
 * author：wanghua
 * @param int $code
 * @param string $msg
 * @param array $data
 * @param bool $is_return_json 是否返回json
 * @return array|string
 */
if (!function_exists('set_res')) {
    function set_res($code = 0, $msg = '', $data = [], $is_return_json = false){
        $r = ['code' => $code, 'msg' => $msg, 'data'=>$data];
        return $is_return_json?json_encode($r):$r;
    }
}
 
/**
 * description：curl请求（整理于微信）
 * author：wanghua
 * @param $url
 * @return mixed
 */
if (!function_exists('req_url')) {
    function req_url($url){
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);//$this->curl_timeout
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //使用代理抓取内容
        //if(\Config::CURL_PROXY_HOST != "0.0.0.0"
        //    && \Config::CURL_PROXY_PORT != 0){
        //    curl_setopt($ch,CURLOPT_PROXY, '0.0.0.0');
        //    curl_setopt($ch,CURLOPT_PROXYPORT, 0);
        //}
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        return json_decode($res,true);
    }
}
 
if (!function_exists('rand_str')) {
    /**
     * 生成随机字符串
     * @param int $length 生成长度
     * @param int $type 生成类型：0-小写字母+数字，1-小写字母，2-大写字母，
     * 3-数字，4-小写+大写字母，5-小写+大写+数字
     * @return string
     */
    function rand_str($length = 8, $type = 0) {
        $a = 'abcdefghijklmnopqrstuvwxyz';
        $A = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $n = '0123456789';
 
        switch ($type) {
            case 1: $chars = $a; break;
            case 2: $chars = $A; break;
            case 3: $chars = $n; break;
            case 4: $chars = $a.$A; break;
            case 5: $chars = $a.$A.$n; break;
            default: $chars = $a.$n;
        }
 
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $str;
    }
}
 
if(!function_exists('arrArrToSort')){
    /**
     * description：php二维数组排序(升、降)
     * author：wanghua
     * @param $data 数据源(必须是二维数组)
     * @param $field 要排序的字段(必须) eg：年龄或者价格
     * @param bool $sort 排序方式
     * @param bool $unique_field 指定唯一字段 eg：例如userID一般都是唯一的
     * @return array 返回排序后的数据源
     */
    function arrArrToSort($data, $field, $sort=true, $unique_field){
        //取出排序源
        $field_arr_key = array_column($data, $unique_field);
        $field_arr_val = array_column($data, $field);
 
        $source_arr = [];
        foreach ($field_arr_key as $key=>$val){
            $source_arr[$val] = $field_arr_val[$key];
        }
 
        //排序
        if($sort)arsort($source_arr);
        else asort($source_arr) ;
        //重组数据
        $new_arr = [];
        foreach ($source_arr as $k=>$v){
            foreach ($data as $a=>$b){
                if($k == $b[$unique_field]){
                    array_push($new_arr, $b);
                }
            }
        }
        return $new_arr;
    }
}
 
if(!function_exists('returnDateString')){
    /**
     * description：日期换算为 今天 昨天 2天前 一周前 一个月前 一年前
     * author：wanghua
     * @param $date 时间戳
     */
    function returnDateString($date){
        $date = $date*1;
        $arr = [
            0=>'今天',
            1=>'昨天',
            2=>'前天',
            7=>'一周前',
            30=>'一个月前',
            365=>'一年前',
            -1=>'很久以前',
        ];
        //今天
        $today = strtotime(date('Y-m-d'));
        if(($date-$today)>=0){
            return $arr[0];
        }else if(($date-$today)<0 && ($today-$date)<=86400){
            return $arr[1];
        }else if(($date-$today)<0 && ($today-$date)<=86400*2){
            return $arr[2];
        }else if(($date-$today)<0 && ($today-$date)<=86400*7){
            return $arr[7];
        }else if(($date-$today)<0 && ($today-$date)<=86400*30){
            return $arr[30];
        }else if(($date-$today)<0 && ($today-$date)<=86400*365){
            return $arr[365];
        }
        return $arr[-1];
    }
}
 
 
if(!function_exists('keyValByArrArr')){
    /**
     * description：返回由二维数组的其中两个字段(键)组成的一维数组
     * author：wanghua
     */
    function keyValByArrArr($data, $key, $key2){
        $data = objToArray($data);
        $arr = array_column($data, $key);
        $arr2 = array_column($data, $key2);
        $tmp = [];
        foreach ($arr as $k=>$v){
            $tmp[$v]=$arr2[$k];
        }
        return $tmp;
    }
}
 
if(!function_exists('returnArrSomeOne')){
    /**
     * description：查找二维数组中某一条数据
     * author：wanghua
     */
    function returnArrSomeOne($data, $field, $val){
        foreach ($data as $k=>$v){
            if($v[$field] == $val){
                return $v;
            }
        }
        return false;
    }
}
 
if(!function_exists('getTabFieldByCon')){
    /**
     * description：查询数据，返回这个字段的列
     * author：wanghua
     * @param $table
     * @param $field
     */
    function getTabFieldByCon($table, $field, $condition=[]){
        if($condition)
        {
            $d = Db::table($table)->field($field)->where($condition)->find();
            return $d[$field];
        }
        else
        {
            $d = Db::table($table)->field($field)->select();
            return array_column($d, $field);
        }
    }
}
 
if(!function_exists('replace_unicode_escape_sequence')){
    /**
     * description：
    调用
    $name = '\u65b0\u6d6a\u5fae\u535a';
    $data = unicodeDecode($name); //输出新浪微博
     * author：wanghua
     * @param $match
     * @return string
     */
    function replace_unicode_escape_sequence($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }
}
 
 
if(!function_exists('unicodeDecode')){
 
    /**
     * description：中文被unicode编码后了的数据，解码出中文 Unicode解码
     * author：wanghua
     * @param $data
     * @return null|string|string[]
     */
    function unicodeDecode($data){
 
        $rs = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $data);
 
        return $rs;
    }
}
 
 
if(!function_exists('unicodeEncode')){
/**
 * description：unicode编码
 * author：wanghua
 * @param $str
 * @return string
 */
    function unicodeEncode($str){
        //split word
        preg_match_all('/./u',$str,$matches);
 
        $unicodeStr = "";
        foreach($matches[0] as $m){
            //拼接
            $unicodeStr .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
        }
        return $unicodeStr;
    }
}
