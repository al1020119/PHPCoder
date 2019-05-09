<?php

include('index002.php');// 只是报错或异常，还是会继续执行
include_once();
require(); // 导致终止，无法继续执行 
require_once();

class name{

public function __construct($a) { // new: 魔术方法，特定的时候自动执行
	echo "iCocos";
	echo $a;
}

	public $s1 = 100;
	public function f1(){
		echo "string1";
		$this->f2();
	}

	// $s2 = 10; // 一定要有public
	function f2() { // 可以没有public
		echo "string2";
	}
}

$name = new name(99);
echo $name->s1;
// echo $name->s2;
$name->f1();
// $name->f2();
var_dump($name);

?>