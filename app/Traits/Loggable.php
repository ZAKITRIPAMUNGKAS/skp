<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait Loggable
{
    protected static function bootLoggable()
    {
        static::created(function ($model) {
            self::logActivity('created', $model);
        });

        static::updated(function ($model) {
            self::logActivity('updated', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('deleted', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        if (auth()->check()) {
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'action'      => $action,
                'model_type'  => get_class($model),
                'model_id'    => $model->id,
                'description' => \Illuminate\Support\Str::ucfirst(auth()->user()->role) . " '" . auth()->user()->name . "' " . $action . " a " . class_basename($model),
                'ip_address'  => request()->ip(),
            ]);
        }
    }
}
