<?php

/*
 * This file is part of the OpenStates Framework (osf) package.
 * (c) Guillaume Ponçon <guillaume.poncon@openstates.com>
 * For the full copyright and license information, please read the LICENSE file distributed with the project.
 */

namespace Osf\Session;

/**
 * Session simulation
 *
 * @author Guillaume Ponçon <guillaume.poncon@openstates.com>
 * @copyright OpenStates
 * @version 1.0
 * @since SMA-0.1 - 2018
 * @package sma
 * @subpackage session
 */
class Mock implements SessionInterface
{
    protected $session = [];
    protected $namespace = AppSession::DEFAULT_NAMESPACE;
    
    /**
     * @param string $namespace
     */
    public function __construct(string $namespace = AppSession::DEFAULT_NAMESPACE)
    {
        $this->namespace = $namespace;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value)
    {
        $this->session[$this->namespace][$key] = $value;
        return $this;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return isset($this->session[$this->namespace][$key]) ? $this->session[$this->namespace][$key] : null;
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
    
    /**
     * @return array
     */
    public function getAll(): array
    {
        return isset($this->session[$this->namespace]) ? $this->session[$this->namespace] : [];
    }
    
    /**
     * @param array $values
     * @return $this
     */
    public function hydrate(array $values)
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
    public function clean(string $key)
    {
        unset($this->session[$this->namespace][$key]);
        return $this;
    }
    
    /**
     * @return $this
     */
    public function cleanAll($commit = true)
    {
        unset($this->session[$this->namespace]);
        return $this;
    }
    
    /**
     * @return bool
     */
    public static function sessionStart(): bool
    {
        return true;
    }

    /**
     * session_destroy() + unset _SESSION
     */
    public static function destroy(): bool
    {
        return true;
    }
}
