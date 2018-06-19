<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/6/2018
 * Time: 4:00 PM
 */
    include_once 'user.php';
    $instance = User::create();
    $instance->logout();