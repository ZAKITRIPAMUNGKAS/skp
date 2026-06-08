<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait Loggable
{
    public $_oldValuesForLogging;
    public $_newValuesForLogging;

    protected static function bootLoggable()
    {
        static::created(function ($model) {
            self::logActivity('created', $model, null, $model->getAttributes());
        });

        static::updating(function ($model) {
            // Kita rekam values sebelum disimpan
            $oldValues = [];
            $newValues = [];
            foreach ($model->getDirty() as $key => $newValue) {
                $oldValues[$key] = $model->getOriginal($key);
                $newValues[$key] = $newValue;
            }
            $model->_oldValuesForLogging = $oldValues;
            $model->_newValuesForLogging = $newValues;
        });

        static::updated(function ($model) {
            $old = isset($model->_oldValuesForLogging) ? $model->_oldValuesForLogging : null;
            $new = isset($model->_newValuesForLogging) ? $model->_newValuesForLogging : null;
            self::logActivity('updated', $model, $old, $new);
        });

        static::deleted(function ($model) {
            self::logActivity('deleted', $model, $model->getAttributes(), null);
        });
    }

    protected static function logActivity($action, $model, $oldValues = null, $newValues = null)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Cari event_id jika model memiliki event_id atau relasi event, atau jika model itu sendiri adalah Event
            $eventId = null;
            if ($model instanceof \App\Models\Event) {
                $eventId = $model->id;
            } elseif (isset($model->event_id)) {
                $eventId = $model->event_id;
            } elseif (method_exists($model, 'event') && $model->event) {
                $eventId = $model->event->id;
            }

            ActivityLog::create([
                'user_id'     => $user->id,
                'event_id'    => $eventId,
                'action'      => $action,
                'role_user'   => $user->role,
                'model_type'  => get_class($model),
                'model_id'    => $model->id,
                'description' => \Illuminate\Support\Str::ucfirst($user->role) . " '" . $user->name . "' " . $action . " a " . class_basename($model),
                'old_values'  => $oldValues,
                'new_values'  => $newValues,
                'ip_address'  => request()->ip(),
            ]);
        }
    }
}
