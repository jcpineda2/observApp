<?php

namespace App\Models\Concerns;

use App\Support\AuditLogger;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function (Model $model) {
            AuditLogger::log(
                event: 'created',
                model: $model,
                oldValues: [],
                newValues: $model->getAttributesForAudit(),
                description: 'Registro creado',
                module: $model->getAuditModuleName(),
            );
        });

        static::updating(function (Model $model) {
            $model->auditOldValues = $model->getOriginalForAudit();
        });

        static::updated(function (Model $model) {
            $oldValues = $model->auditOldValues ?? [];
            $newValues = $model->getDirtyForAuditComparedTo($oldValues);

            if (empty($newValues)) {
                return;
            }

            AuditLogger::log(
                event: 'updated',
                model: $model,
                oldValues: $oldValues,
                newValues: $newValues,
                description: 'Registro actualizado',
                module: $model->getAuditModuleName(),
            );
        });

        static::deleted(function (Model $model) {
            AuditLogger::log(
                event: 'deleted',
                model: $model,
                oldValues: $model->getAttributesForAudit(),
                newValues: [],
                description: 'Registro eliminado',
                module: $model->getAuditModuleName(),
            );
        });
    }

    public function getAuditModuleName(): string
    {
        return class_basename($this);
    }

    public function getAuditExcludedAttributes(): array
    {
        return [
            'created_at',
            'updated_at',
        ];
    }

    public function getAttributesForAudit(): array
    {
        return collect($this->getAttributes())
            ->except($this->getAuditExcludedAttributes())
            ->toArray();
    }

    public function getOriginalForAudit(): array
    {
        return collect($this->getOriginal())
            ->except($this->getAuditExcludedAttributes())
            ->toArray();
    }

    public function getDirtyForAuditComparedTo(array $oldValues): array
    {
        $current = $this->getAttributesForAudit();

        $changed = [];

        foreach ($current as $key => $value) {
            $oldValue = $oldValues[$key] ?? null;

            if ($oldValue != $value) {
                $changed[$key] = $value;
            }
        }

        return $changed;
    }
}
