<?php

require_once "CacheAbstract.php";

class Cache extends CacheAbstract
{
    protected $cachedir;
    private $fileDir = __DIR__ . '/cache-file/cache';

    public function __construct(){}

    public function set(string $key, $value, int $duration)
    {
        $duration = $this->getDuration($duration);
		$data = new stdClass;
		$data->duration = null;
		$data->content = $value;
		if($duration !== null){
            $time = time() - $duration;
            $modifiedTime = filemtime($this->fileDir);
            $mixed = time() + $duration;
            $data->duration = $mixed;
            if($modifiedTime > $time){
                //echo "Append";
                file_put_contents($this->fileDir, serialize($data), FILE_APPEND);  
                return $mixed;
            } else {
                //echo "New";
                file_put_contents($this->fileDir, serialize($data));  
                return $mixed;
            }
        }
        return null;
    }

    public function get(string $key)
    {
        $content = file_get_contents($this->fileDir);
        if(!empty($content)){
            $data = unserialize($content);
            if($data->duration === null || $data->duration > time()){
                var_dump($data->content);
                return $data->content;
            }
            file_put_contents($this->fileDir, '');  
            //unlink($this->fileDir);
        }
        return null;
    }
}

// $obj = new Cache();
// $abc = $obj->set("1", "Pheakdey Luk", 300);

?>