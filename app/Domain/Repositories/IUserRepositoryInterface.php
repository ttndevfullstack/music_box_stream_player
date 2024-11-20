<?php

namespace App\Domain\Repositories;

interface IUserRepositoryInterface
{
    public function getDefaultAdminUser();
    public function findOneByEmail(string $email);
    // public function findOneBySSO(string $email);
}
