<?php

namespace App\Interfaces;

interface TemplateSectionInterface
{
    public function index(int $items = 10);
    public function show(string $id);
    public function store(array $data);
    public function update(string $id, array $data);
    public function destroy(string $id);
    public function getTemplateSections(string $templateId);
}
