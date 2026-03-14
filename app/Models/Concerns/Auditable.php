<?php

namespace App\Models\Concerns;

use App\Support\AuditLogger;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    /**
     * Guarda el estado original del modelo antes de actualizarse.
     * Esta propiedad es interna y no debe persistirse en la base de datos.
     */
    protected array $auditOriginalValues = [];

    /**
     * Boot del trait.
     */
    public static function bootAuditable(): void
    {
        static::created(function (Model $model): void {
            $newValues = $model->getAttributesForAudit();

            if (empty($newValues)) {
                return;
            }

            AuditLogger::log(
                event: 'created',
                model: $model,
                oldValues: [],
                newValues: $newValues,
                description: $model->getAuditDescription('created'),
                module: $model->getAuditModuleName(),
            );
        });

        static::updating(function (Model $model): void {
            $model->auditOriginalValues = $model->getOriginalForAudit();
        });

        static::updated(function (Model $model): void {
            $oldValues = $model->getChangedOldValuesForAudit();
            $newValues = $model->getChangedNewValuesForAudit();

            if (empty($newValues)) {
                return;
            }

            AuditLogger::log(
                event: 'updated',
                model: $model,
                oldValues: $oldValues,
                newValues: $newValues,
                description: $model->getAuditDescription('updated'),
                module: $model->getAuditModuleName(),
            );
        });

        static::deleted(function (Model $model): void {
            $oldValues = $model->getAttributesForAudit();

            if (empty($oldValues)) {
                return;
            }

            AuditLogger::log(
                event: 'deleted',
                model: $model,
                oldValues: $oldValues,
                newValues: [],
                description: $model->getAuditDescription('deleted'),
                module: $model->getAuditModuleName(),
            );
        });
    }

    /**
     * Nombre del módulo que aparecerá en la auditoría.
     * Puede sobrescribirse en cada modelo.
     */
    public function getAuditModuleName(): string
    {
        return class_basename($this);
    }

    /**
     * Descripción legible por evento.
     * Puede sobrescribirse en cada modelo si deseas algo más específico.
     */
    public function getAuditDescription(string $event): string
    {
        return match ($event) {
            'created' => 'Registro creado',
            'updated' => 'Registro actualizado',
            'deleted' => 'Registro eliminado',
            default => 'Acción registrada',
        };
    }

    /**
     * Campos que no deben auditarse.
     * Puede sobrescribirse por modelo.
     */
    public function getAuditExcludedAttributes(): array
    {
        return [
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }

    /**
     * Devuelve los atributos actuales del modelo que sí deben auditarse.
     */
    public function getAttributesForAudit(): array
    {
        return collect($this->attributesToArray())
            ->except($this->getAuditExcludedAttributes())
            ->toArray();
    }

    /**
     * Devuelve los atributos originales del modelo que sí deben auditarse.
     */
    public function getOriginalForAudit(): array
    {
        return collect($this->getRawOriginal())
            ->except($this->getAuditExcludedAttributes())
            ->toArray();
    }

    /**
     * Devuelve solo los valores anteriores de los campos modificados.
     */
    public function getChangedOldValuesForAudit(): array
    {
        $current = $this->getAttributesForAudit();
        $original = $this->auditOriginalValues;

        $changedOldValues = [];

        foreach ($current as $key => $newValue) {
            $oldValue = $original[$key] ?? null;

            if ($this->auditValuesAreDifferent($oldValue, $newValue)) {
                $changedOldValues[$key] = $oldValue;
            }
        }

        return $changedOldValues;
    }

    /**
     * Devuelve solo los valores nuevos de los campos modificados.
     */
    public function getChangedNewValuesForAudit(): array
    {
        $current = $this->getAttributesForAudit();
        $original = $this->auditOriginalValues;

        $changedNewValues = [];

        foreach ($current as $key => $newValue) {
            $oldValue = $original[$key] ?? null;

            if ($this->auditValuesAreDifferent($oldValue, $newValue)) {
                $changedNewValues[$key] = $newValue;
            }
        }

        return $changedNewValues;
    }

    /**
     * Compara dos valores de forma segura para auditoría.
     */
    protected function auditValuesAreDifferent(mixed $oldValue, mixed $newValue): bool
    {
        return $this->normalizeAuditValue($oldValue) !== $this->normalizeAuditValue($newValue);
    }

    /**
     * Normaliza valores para comparación consistente.
     */
    protected function normalizeAuditValue(mixed $value): mixed
    {
        if (is_bool($value)) {
            return (int) $value;
        }

        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $value;
    }
}
