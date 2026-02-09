<?php

namespace App\Traits;

use App\Models\Log;

trait LogActivity
{
    public static function bootLogActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', null, $model->toArray());
        });

        static::updated(function ($model) {
            $model->logActivity('updated', $model->getOriginal(), $model->toArray());
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->toArray(), null);
        });
    }

    public function logActivity($action, $oldData = null, $newData = null)
    {
        Log::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'description' => $this->getLogDescription($action),
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function getLogDescription($action)
    {
        $modelName = class_basename(get_class($this));
        return "{$modelName} {$action}";
    }
}