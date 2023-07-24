<?php

namespace App\Traits;

use \Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, array $data)
    {
        if (!$this->isSearchable($data))
        {
            throw new \InvalidArgumentException('Invalid argument');
        }
        
        foreach($this->getSearchableFields() as $field)
        {
            if (array_key_exists($field, $data))
            {
                $keyword = $data[$field];

                $query->orWhere($field, 'LIKE', "%$keyword%");
            }
        }
    }

    private function isSearchable(array $data)
    {
        foreach(array_keys($data) as $field)
        {
            if (!in_array($field, $this->getSearchableFields()))
            {
                return false;
            }
        }

        return true;
    }

    private function getSearchableFields()
    {
        if (property_exists($this, 'searchable'))
        {
            return $this->searchable;
        }
        else if (method_exists($this, 'searchable'))
        {
            return $this->searchable();
        }

        return [];
    }
}