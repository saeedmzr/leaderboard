<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }


    public function findById(
        int   $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model
    {
        $object = $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);

        return $object;
    }


    public function create(array $payload): ?Model
    {

        $model = $this->model->create($payload);
        return $model;
    }


    public function update(int $modelId, array $payload): bool
    {

        $model = $this->findById($modelId);
        $new_obj = $model->update($payload);

        return $new_obj;
    }

    public function deleteById(int $modelId): bool
    {
        $deleted_item = $this->findById($modelId);
        return $this->findById($modelId)->delete();
    }

}
