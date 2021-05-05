<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kus;

/**
 * Description of SingleTon
 *
 * @author spotu
 */
trait SingletonTrait {
    protected static $_instance;

    protected function __construct() { }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    protected function __clone() { }
    protected function __sleep() { }
    protected function __wakeup() { }
}