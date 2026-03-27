<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'listing_id',
        'amount',
        'status', // Success, Pending, Failed
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
