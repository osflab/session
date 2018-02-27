<?php

/*
 * This file is part of the OpenStates Framework (osf) package.
 * (c) Guillaume Ponçon <guillaume.poncon@openstates.com>
 * For the full copyright and license information, please read the LICENSE file distributed with the project.
 */

namespace Osf\Session;

use Osf\Session\AppSession;

/**
 * @author Guillaume Ponçon <guillaume.poncon@openstates.com>
 * @copyright OpenStates
 * @version 1.0
 * @since OSF-3.0.1 - 2018
 * @package osf
 * @subpackage session
 */
interface SessionInterface
{
    /**
     * @param string $namespace
     */
    public function __construct(string $namespace = AppSession::DEFAULT_NAMESPACE);
    
    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value);
    
    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function __set($key, $value);
    
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);
    
    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key);
    
    /**
     * @return array
     */
    public function getAll(): array;
    
    /**
     * @param array $values
     * @return $this
     */
    public function hydrate(array $values);
    
    /**
     * @param string $key
     * @return $this
     */
    public function clean(string $key);
    
    /**
     * @return $this
     */
    public function cleanAll($commit = true);
    
    /**
     * @return bool
     */
    public static function sessionStart(): bool;

    /**
     * session_destroy() + unset _SESSION
     */
    public static function destroy(): bool;
}
