<?php

require_once "CacheInterface.php";

abstract class CacheAbstract implements CacheInterface
{
    protected function getDuration($duration):?int{
		if($duration instanceof DateInterval){
			return (new DateTime)->add($duration)->getTimeStamp() - time();
		}
		else if((is_int($duration) && $duration > 0) || $duration === null){
			return $duration;
		}
        $msg = 'Invalid Duration';
        echo $msg;
		throw new Exception($msg);
    }
}