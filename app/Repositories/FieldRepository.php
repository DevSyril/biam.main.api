<?php

namespace App\Repositories;

use App\Interfaces\FieldInterface;
use App\Models\FormField;

class FieldRepository implements FieldInterface
{
    public function index(int $items = 10)
    {
        return FormField::paginate($items);
    }

    public function show(string $id)
    {
        return FormField::findOrFail($id);
    }

    public function store(array $data)
    {
        return FormField::create($data);
    }

    public function update(string $id, array $data)
    {
        return FormField::findOrFail($id)->update($data);
    }

    public function destroy(string $id)
    {
        return FormField::findOrFail($id)->delete();
    }
}
