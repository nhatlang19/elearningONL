<?php
class Lphcache {
    protected $CI;
    protected $cacheConfig;
    protected $cacheObject;
    
    function __construct()
    {
        $this->CI = & get_instance();
        $this->cacheConfig = $this->CI->config->item('cache.name');
        
        // cache driver
        $driver = $this->CI->config->item('cache.driver');
        $this->cacheObject = $this->CI->cache->$driver;
    }
    
    public function getCacheName($tableName, $function) {
        return isset($this->cacheConfig[$tableName][$function]) ? $this->cacheConfig[$tableName][$function] : null;
    }
    
    public function cleanCacheByFunction($tableName, $function) {
        $cacheName = $this->getCacheName($tableName, $function);
        if($cacheName) {
            return $this->delete($cacheName);
        }
        return false;
    }
    
    public function delete($id) {
        return $this->cacheObject->delete($id);
    }
    
    public function get($id) {
        return $this->cacheObject->get($id);
    }
    
    /**
    * 
    * @param string $id Cache item name
    * @param mixed $data the data to save
    * @param int $ttl Time To Live, in seconds (default 60)
    * @return TRUE on success, FALSE on failure
    */
    public function save($id, $data, $ttl) {
        return $this->cacheObject->save($id, $data, $ttl);
    }
}
