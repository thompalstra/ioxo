<?php
namespace io\web;

interface IdentityInterface{
    public function login($model);
    public function logout();
}

?>
