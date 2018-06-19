<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2018
 * Time: 10:33 PM
 */

    interface Authenticator{
        public function hashPasssword();
        public function isPasswordCorrect();
        public function login();
        public function logout();
        public function createFormErrorSessions();
    }