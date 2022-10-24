<?php

namespace App\Models;

use App\Enums\EnumGeneral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip',
        'mac_address',
        'is_active',
        'type',
    ];


    public static function get_enums($columnName)
    {
        return EnumGeneral::getEnumValues('hardware_schedules', $columnName);
    }

    public function schedule_times()
    {
        return $this->hasMany(HardwareSchedule::class);
    }
}
