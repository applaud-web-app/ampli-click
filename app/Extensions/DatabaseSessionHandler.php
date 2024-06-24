<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\Factory;
use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class DatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    protected function addUserInformation(&$payload)
    {
        if ($this->container->bound(Factory::class)) {
            $payload['user_id'] = $this->webUserId();
            $payload['student_user_id'] = $this->studentUserId();
            $payload['teacher_user_id'] = $this->teacherUserId();
        }

        return $this;
    }

    protected function webUserId()
    {
        $user = $this->getUser('web');
        
        return $user ? $user->id : null;
    }

    protected function studentUserId()
    {
        $user = $this->getUser('student');
        
        return $user ? $user->id : null;
    }
    protected function teacherUserId()
    {
        $user = $this->getUser('teacher');
        
        return $user ? $user->id : null;
    }

    protected function getUser($guard)
    {
        return $this->container->make(Factory::class)->guard($guard)->user();
    }
}
