<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    use HasUuids;

    protected $fillable = ['listing_id', 'photo_path', 'sort_order'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
