<?php

namespace App\Repositories;

use App\Interfaces\TemplateFieldInterface;
use App\Models\TemplateField;

class TemplateFieldRepository implements TemplateFieldInterface
{
    public function index($items = 10)
    {
        return TemplateField::paginate($items);
    }

    public function store(array $data)
    {
        return TemplateField::create($data);
    }

    public function show(string $id)
    {
        return TemplateField::findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $templateField = TemplateField::findOrFail($id);
        $templateField->update($data);
        return $templateField;
    }

    public function destroy(string $id)
    {
        $templateField = TemplateField::findOrFail($id);
        return $templateField->delete();
    }
}
