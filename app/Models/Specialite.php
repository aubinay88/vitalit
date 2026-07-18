<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    // Une spécialité appartient à un hôpital
    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }
    protected $guarded = [];
}
