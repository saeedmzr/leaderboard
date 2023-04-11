<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;



    public function findById(
        int   $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;


    public function create(array $payload): ?Model;

    public function update(int $modelId, array $payload): bool;

    public function deleteById(int $modelId): bool;

}
