<?php

namespace App\Traits\Traits;

use Illuminate\Support\Str;

trait HasUuidPrimaryKey
{
    public static function bootHasUuidPrimaryKey()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected function initializeHasUuidPrimaryKey()
    {
        $this->casts[$this->getKeyName()] = 'string';
    }

}
