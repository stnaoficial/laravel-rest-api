<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasBaseRepository
{
    private Model $entity;

    private string $identifier;

    public function setEntity(Model $entity)
    {
        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function all()
    {
        return $this->entity->all();
    }

    public function search(array $data)
    {
        return $this->entity->search($data)->get();
    }

    public function searchOne(array $data)
    {
        return $this->entity->search($data)->first();
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function identifierExists(mixed $value)
    {
        return $this->entity->where($this->getIdentifier(), $value)->exists();
    }

    public function existsById(int $id)
    {
        return $this->setIdentifier('id')->identifierExists($id);
    }

    public function updateByIdentifier(mixed $value, array $data)
    {
        return $this->entity->where($this->getIdentifier(), $value)->update($data);
    }

    public function deleteByIdentifier(mixed $value)
    {
        return $this->entity->destroy($this->getIdentifier(), $value);
    }

    public function findOneByIdentifier(mixed $value)
    {
        return $this->entity->where($this->getIdentifier(), $value)->first();
    }

    public function findInIdentifier(array $values)
    {
        return $this->entity->whereIn($this->getIdentifier(), $values)->get();
    }

    public function findOneById(int $id)
    {
        return $this->setIdentifier('id')->findOneByIdentifier($id);
    }
    
    public function updateById(int $id, array $data)
    {
        return $this->setIdentifier('id')->updateByIdentifier($id, $data);
    }

    public function deleteById(int $id)
    {
        return $this->setIdentifier('id')->deleteByIdentifier($id);
    }
}