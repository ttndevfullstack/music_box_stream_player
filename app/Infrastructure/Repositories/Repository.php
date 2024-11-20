<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Infrastructure\Repositories\Contracts\IRepositoryInterface;

class Repository implements IRepositoryInterface
{
    private string $modelClass;
    protected Guard $guard;
    public Model $model;

    public function __construct(?string $modelClass = null)
    {
        $this->modelClass = $modelClass ?: self::guessModelClass();
        $this->model = app($this->modelClass);
    }

    public function guessModelClass(): string
    {
        return preg_replace('/(.+)\\\\Infrastructure\\\\Repositories\\\\(.+)Repository$/m', '$1\Presentation\Models\\\$2', static::class);
    }

    public function getOne(int $id): Model
    {
        return $this->model::query()->findOrFail($id);
    }

    public function getOneBy(...$params): ?Model
    {
        return $this->model::query()->where(...$params)->firstOrFail();
    }

    public function getMany(array $ids, bool $preserveOrder = false): Collection
    {
        $models = $this->model::query()->find($ids);
        
        return $preserveOrder ? $models->orderByArray($ids) : $models;
    }

    public function  getAll(): Collection
    {
        return $this->model::query()->all();

    }

    public function findOne(int $id): ?Model
    {
        return $this->model::query()->find($id);
    }

    public function findOneBy(...$params): ?Model
    {
        return $this->model::query()->where(...$params)->first();
    }

    public function findFirstWhere(...$params): ?Model
    {
        return $this->model::query()->firstWhere(...$params);
    }
}
