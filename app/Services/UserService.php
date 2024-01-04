<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function Query()
    {
        return $this->user->query();
    }

    public function show($id)
    {
        $user = $this->user->find($id);
        return $user;
    }

    public function store($data)
    {
        return $this->user->create($data);
    }
}
