<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
       'hardware_id',
       'day', //['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
       'is_active',
       'time',
       'action',
    ];

    public function hardware() {
        return $this->belongsTo(Hardware::class, 'hardware_id');
    }
}
