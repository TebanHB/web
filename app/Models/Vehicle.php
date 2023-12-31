<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['model', 'make', 'color', 'year', 'client_id'];

    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
