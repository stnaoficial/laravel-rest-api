<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function setEntity(Model $entity);
    public function getEntity();
    public function setIdentifier(string $identifier);
    public function getIdentifier();
    public function all();
    public function create(array $data);
    public function identifierExists(mixed $value);
    public function existsById(int $id);
    public function updateByIdentifier(mixed $value, array $data);
    public function deleteByIdentifier(mixed $value);
    public function search(array $data);
    public function searchOne(array $data);
    public function findOneByIdentifier(mixed $value);
    public function findInIdentifier(array $values);
    public function findOneById(int $id);
    public function updateById(int $id, array $data);
    public function deleteById(int $id);
}