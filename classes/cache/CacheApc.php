<?php

/**
 * This class require PECL APC extension
 *
 * @since 1.5.0
 */
class CacheApcCore extends Cache {

    public function __construct() {
        if (!function_exists('apc_exists')) {
            $this->keys = array();
            $cache_info = apc_cache_info((extension_loaded('apcu') === true) ? '' : 'user');
            foreach ($cache_info['cache_list'] as $entry) {
                if (isset($entry['key']))
                    $this->keys[$entry['key']] = $entry['ttl'];
                else
                    $this->keys[$entry['info']] = $entry['ttl'];
            }
        }
    }

    /**
     * Delete one or several data from cache (* joker can be used, but avoid it !)
     * 	E.g.: delete('*'); delete('my_prefix_*'); delete('my_key_name');
     *
     * @param string $key
     * @return bool
     */
    public function delete($key) {
        if ($key == '*')
            $this->flush();
        elseif (strpos($key, '*') === false)
            $this->_delete($key);
        else {
            $pattern = str_replace('\\*', '.*', preg_quote($key));

            $cache_info = apc_cache_info((extension_loaded('apcu') === true) ? '' : 'user');
            foreach ($cache_info['cache_list'] as $entry) {
                if (isset($entry['key']))
                    $key = $entry['key'];
                else
                    $key = $entry['info'];
                if (preg_match('#^' . $pattern . '$#', $key))
                    $this->_delete($key);
            }
        }
        return true;
    }

    /**
     * @see Cache::_set()
     */
    protected function _set($key, $value, $ttl = 0) {
        return apc_store($key, $value, $ttl);
    }

    /**
     * @see Cache::_get()
     */
    protected function _get($key) {
        return apc_fetch($key);
    }

    /**
     * @see Cache::_exists()
     */
    protected function _exists($key) {
        if (!function_exists('apc_exists'))
            return isset($this->keys[$key]);
        else
            return apc_exists($key);
    }

    /**
     * @see Cache::_delete()
     */
    protected function _delete($key) {
        return apc_delete($key);
    }

    /**
     * @see Cache::_writeKeys()
     */
    protected function _writeKeys() {
        
    }

    /**
     * @see Cache::flush()
     */
    public function flush() {
        return apc_clear_cache();
    }

    /**
     * Store a data in cache
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = 0) {
        return $this->_set($key, $value, $ttl);
    }

    /**
     * Retrieve a data from cache
     *
     * @param string $key
     * @return mixed
     */
    public function get($key) {
        return $this->_get($key);
    }

    /**
     * Check if a data is cached
     *
     * @param string $key
     * @return bool
     */
    public function exists($key) {
        return $this->_exists($key);
    }

}
