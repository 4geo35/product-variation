<?php

namespace GIS\ProductVariation\Policies;

use App\Models\User;
use GIS\ProductVariation\Interfaces\MeasurementUnitInterface;
use GIS\UserManagement\Facades\PermissionActions;
use GIS\UserManagement\Interfaces\PolicyPermissionInterface;

class MeasurementUnitPolicy implements PolicyPermissionInterface
{
    const PERMISSION_KEY = "measurement_units";
    const VIEW_ALL = 2;
    const CREATE = 4;
    const UPDATE = 8;
    const DELETE = 16;

    public static function getPermissions(): array
    {
        return [
            self::VIEW_ALL => "Просмотр всех",
            self::CREATE => "Создание",
            self::UPDATE => "Обновление",
            self::DELETE => "Удаление",
        ];
    }

    public static function getDefaults(): int
    {
        return self::VIEW_ALL + self::CREATE + self::UPDATE + self::DELETE;
    }

    public function viewAny(User $user): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::VIEW_ALL);
    }

    public function create(User $user): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::CREATE);
    }

    public function update(User $user, MeasurementUnitInterface $unit): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::UPDATE);
    }

    public function delete(User $user, MeasurementUnitInterface $unit): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::DELETE);
    }
}
