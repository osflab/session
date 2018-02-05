<?php

/*
 * This file is part of the OpenStates Framework (osf) package.
 * (c) Guillaume Ponçon <guillaume.poncon@openstates.com>
 * For the full copyright and license information, please read the LICENSE file distributed with the project.
 */

namespace Osf\Session;

use Osf\Container\OsfContainer as OsfContainer;
use Osf\Session\AppSession as Session;

/**
 * Session container with static methods
 *
 * @author Guillaume Ponçon <guillaume.poncon@openstates.com>
 * @copyright OpenStates
 * @version 1.0
 * @since OSF-2.0 - 2017
 * @package sma
 * @subpackage session
 */
abstract class Container
{
    protected static function getNamespace()
    {
        return property_exists(static::class, 'namespace') ? static::$namespace : Session::DEFAULT_NAMESPACE;
    }
    
    /**
     * @return \Osf\Session\AppSession
     */
    public static function getSession()
    {
        return OsfContainer::getSession(self::getNamespace());
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return \Osf\Session\AppSession
     */
    public static function set(string $key, $value)
    {
        return self::getSession()->set($key, $value);
    }
    
    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key, string $subKey = null)
    {
        $value = self::getSession()->get($key);
        if (!$subKey) {
            return $value;
        }
        return isset($value[$subKey]) ? $value[$subKey] : null;
    }
    
    /**
     * @return array
     */
    public static function getAll():array
    {
        return self::getSession()->getAll();
    }
    
    /**
     * @param string $key
     * @return \Osf\Session\AppSession
     */
    public static function clean(string $key)
    {
        return self::getSession()->clean($key);
    }
    
    /**
     * @return \Osf\Session\AppSession
     */
    public static function cleanAll()
    {
        return self::getSession()->cleanAll();
    }
    
    /**
     * @param array $values
     * @return \Osf\Session\AppSession
     */
    public static function hydrate(array $values)
    {
        return self::getSession()->hydrate($values);
    }
}
