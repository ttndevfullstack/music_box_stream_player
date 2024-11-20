<?php

namespace App\Infrastructure\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface IRepositoryInterface
{
    public function getOne(int $id): Model;
    
    public function findOne(int $id): ?Model;

    public function getMany(array $ids, bool $preserveOrder): Collection;

    public function  getAll(): Collection;
}