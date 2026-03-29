<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = ['name', 'slug', 'address', 'description', 'city', 'district', 'price', 'facilities', 'main_photo', 'status', 'is_premium', 'premium_status', 'premium_payment_proof', 'owner_id', 'category_id', 'rejection_reason', 'rejection_notes'];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
