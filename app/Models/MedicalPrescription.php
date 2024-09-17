<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPrescription extends Model
{
    use HasFactory;

    protected $primaryKey = 'prescription_id';
    protected $fillable = ['title', 'description', 'appointment_id'];

    // Relationships
    public function appointment()
    {
        return $this->belongsTo(User::class, 'appointment_id');
    }
}
