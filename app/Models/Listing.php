<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = ['name', 'address', 'price', 'status', 'is_premium', 'owner_id', 'rejection_reason', 'rejection_notes'];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
