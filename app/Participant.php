<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'emergency_contact_id'
    ];

    public function allergies()
    {
        return $this->belongsToMany(Allergy::class);
    }

    public function emergencyContact()
    {
        return $this->belongsTo(EmergencyContact::class);
    }
}
