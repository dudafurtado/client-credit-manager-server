<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Client;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'expire_date',
        'CVV'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
