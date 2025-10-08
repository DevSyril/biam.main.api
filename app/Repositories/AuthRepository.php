<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;

class AuthRepository implements AuthInterface
{
    public function register(array $data) {

        $user = User::create($data);

    }

    public function login(array $data) {

    }

    public function logout() {

    }


    public function user() {

    }

    public function updateProfile(array $data) {

    }

    public function changePassword(array $data) {

    }


    public function saveNewAdmin(array $data) {
        
    }
}
