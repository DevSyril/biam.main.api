<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function register(array $data);
    public function login(array $data);
    public function logout();
    public function user();
    public function updateProfile(array $data);
    public function changePassword(array $data);
    public function saveNewAdmin(array $data);
}
