<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UseUUID {

    public static function boot()
    {
        parent::boot();
        $user = auth()->user();
        static::creating(function ($model) use ($user) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
            if ($user) {
                $model->created_by = $user->name;
                $model->updated_by = $user->name;
            }
        });

        static::updating(function ($model) use ($user) {
            if ($user) {
                $model->updated_by = $user->name;
            }
        });

        static::deleting(function ($model) use ($user) {
            if ($user) {
                $model->deleted_by = $user->name;
                $model->save();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}