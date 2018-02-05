<?php

/*
 * This file is part of the OpenStates Framework (osf) package.
 * (c) Guillaume Ponçon <guillaume.poncon@openstates.com>
 * For the full copyright and license information, please read the LICENSE file distributed with the project.
 */

namespace Osf\Session;

/**
 * Sessions management (lazy loading session)
 *
 * @author Guillaume Ponçon <guillaume.poncon@openstates.com>
 * @copyright OpenStates
 * @version 1.0
 * @since OSF-2.0 - 2017
 * @package osf
 * @subpackage session
 */
class AppSession
{
    const DEFAULT_NAMESPACE = 'default';
    
    protected $started = false;
    protected $namespace;
    
    /**
     * @param string $namespace
     */
    public function __construct(string $namespace = self::DEFAULT_NAMESPACE)
    {
        $this->namespace = $namespace;
    }
    
    /**
     * Check if session started, if not start it
     * @return bool
     */
    protected function checkStarted():bool
    {
        if (!$this->started) {
            $this->started = self::sessionStart();
        }
        if (isset($_SESSION[$this->namespace]) && !is_array($_SESSION[$this->namespace])) {
            $_SESSION[$this->namespace] = [];
        }
        return (bool) $this->started;
    }
    
    /**
     * @param string $key
     * @param type $value
     * @return $this
     */
    public function set(string $key, $value)
    {
        if ($this->checkStarted()) {
            $_SESSION[$this->namespace][$key] = $value;
        }
        return $this;
    }
    
    public function __set($key, $value) {
        return $this->set($key, $value);
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->checkStarted()) {
            return isset($_SESSION[$this->namespace][$key]) 
                    ? $_SESSION[$this->namespace][$key] 
                    : null;
        }
        return null;
    }
    
    public function __get($key)
    {
        return $this->get($key);
    }
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return isset($_SESSION[$this->namespace]) && is_array($_SESSION[$this->namespace]) ? $_SESSION[$this->namespace] : [];
    }
    
    /**
     * @param array $values
     * @return $this
     */
    public function hydrate(array $values):self
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
        return $this;
    }
    
    /**
     * @param string $key
     * @return $this
     */
    public function clean(string $key):self
    {
        if ($this->checkStarted() && isset($_SESSION[$this->namespace][$key])) {
            unset($_SESSION[$this->namespace][$key]);
        }
        return $this;
    }
    
    /**
     * @return $this
     */
    public function cleanAll($commit = true):self
    {
        if ($this->checkStarted() && isset($_SESSION[$this->namespace])) {
            unset($_SESSION[$this->namespace]);
            $commit && session_write_close();
        }
        return $this;
    }
    
    /**
     * @return bool
     */
    public static function sessionStart()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return true;
        }
        session_cache_limiter('nocache');
        if (session_start()) {
            session_regenerate_id();
            return true;
        }
        return false;
    }

    /**
     * session_destroy() + unset _SESSION
     */
    public static function destroy()
    {
        $_SESSION = null;
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
