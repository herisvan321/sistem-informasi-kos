<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = ['title', 'reporter_id', 'listing_id', 'status', 'type', 'description'];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
}
