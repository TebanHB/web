<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\ServiceRequest;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'vehicle_id', 'file_path', 'service_request_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
