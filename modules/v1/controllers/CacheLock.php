<?php
namespace app\modules\v1\controllers;

class CacheLock
{
	//文件锁存放路径
	private $path = null;
	//文件句柄
	private $fp = null;
	//锁粒度,设置越大粒度越小
	private $hashNum = 100;
	//cache key
	private $name;
	//是否存在eaccelerator标志
	private $eAccelerator = false;
	/**
	 * 构造函数
	 * 传入锁的存放路径，及cache key的名称，这样可以进行并发
	 * @param string $path 锁的存放目录，以"/"结尾
	 * @param string $name cache key
	 */
	public function __construct($name,$path='/tmp/')
	{
		//判断是否存在eAccelerator,这里启用了eAccelerator之后可以进行内存锁提高效率
		$this->eAccelerator = function_exists("eaccelerator_lock");
		if(!$this->eAccelerator)
		{
			$this->path = $path.($this->_mycrc32($name) % $this->hashNum).'.txt';
		}
		$this->name = $name;
	}
	/**
	 * crc32
	 * crc32封装
	 * @param int $string
	 * @return int
	 */
	private function _mycrc32($string)
	{
		$crc = abs (crc32($string));
		if ($crc & 0x80000000) {
			$crc ^= 0xffffffff;
			$crc += 1;
		}
		return $crc;
	}
	/**
	 * 加锁
	 * Enter description here ...
	 */
	public function lock()
	{
		//如果无法开启ea内存锁，则开启文件锁
		if(!$this->eAccelerator)
		{
			//配置目录权限可写
			$this->fp = fopen($this->path, 'w+');
			if($this->fp === false)
			{
				return false;
			}
			return flock($this->fp, LOCK_EX);
		}else{
			return eaccelerator_lock($this->name);
		}
	}
	/**
	 * 解锁
	 * Enter description here ...
	 */
	public function unlock()
	{
		if(!$this->eAccelerator)
		{
			if($this->fp !== false)
			{
				flock($this->fp, LOCK_UN);
				clearstatcache();
			}
			//进行关闭
			fclose($this->fp);
		}else{
			return eaccelerator_unlock($this->name);
		}
	}
}