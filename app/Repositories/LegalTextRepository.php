<?php

namespace App\Repositories;

use App\Interfaces\LegalTextInterface;
use App\Models\LegalText;
use Carbon\Carbon;

class LegalTextRepository implements LegalTextInterface
{
    public function index($items = 10)
    {
        return LegalText::paginate($items);
    }

    public function store(array $data)
    {
        return LegalText::create($data);
    }

    public function show(string $id)
    {
        $legal_text = LegalText::findOrFail($id);
        return $legal_text->load('articles');
    }

    public function update(string $id, array $data)
    {
        $item = LegalText::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function destroy(string $id)
    {
        $item = LegalText::findOrFail($id);
        return $item->delete();
    }

    public function abrogate(string $id)
    {
        $item = LegalText::findOrFail($id);
        $item->abrogation_date = Carbon::now();
        $item->save();
        return $item;
    }
}