<?php

namespace App\Services;

use App\Database;

class RegisterService
{
    public function execute(RegisterServiceRequest $request): void
    {
        $queryBuilder = (new Database())->getConnection()->createQueryBuilder();
        $queryBuilder->insert('users')
            ->values([
                'name' => '?',
                'email' => '?',
                'password' => '?'
            ])
            ->setParameter(0, $request->getName())
            ->setParameter(1, $request->getEmail())
            ->setParameter(2, password_hash($request->getPassword(), PASSWORD_DEFAULT))
            ->executeQuery();
    }
}

