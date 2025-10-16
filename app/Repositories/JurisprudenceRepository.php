<?php

namespace App\Repositories;

use App\Interfaces\JurisprudenceInterface;
use App\Models\Jurisprudence;

class JurisprudenceRepository implements JurisprudenceInterface
{
    public function index($items = 10)
    {
        $jurispruddence = Jurisprudence::paginate($items);
        $jurispruddence->load('legal_subject');
        return $jurispruddence;
    }

    public function store(array $data)
    {
        return Jurisprudence::create($data);
    }

    public function show(string $id)
    {
        return Jurisprudence::with(['legal_subject'])->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $item = Jurisprudence::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function destroy(string $id)
    {
        $item = Jurisprudence::findOrFail($id);
        return $item->delete();
    }
}
