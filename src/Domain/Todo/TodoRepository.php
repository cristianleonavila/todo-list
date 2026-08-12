<?php

namespace App\Domain\Todo;

use App\Domain\User\User;

interface TodoRepository
{
    public function save(Todo $todo);

    public function findById($id);

    public function findByUser(User $user);

    public function delete(Todo $todo);
}