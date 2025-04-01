<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function register($data);
    public function login($credentials);
    public function logout();
}
