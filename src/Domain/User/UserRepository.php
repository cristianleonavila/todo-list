<?php

namespace App\Domain\User;

interface UserRepository
{
    public function save(User $user);

    public function findById($id);

    public function findByUsername($username);
}