<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hopital extends Model
{
    // Un hôpital possède plusieurs lits
    public function lits()
    {
        return $this->hasMany(Lit::class);
    }

    // Un hôpital possède plusieurs spécialités
    public function specialites()
    {
        return $this->hasMany(Specialite::class);
    }
    protected $guarded = [];
}
