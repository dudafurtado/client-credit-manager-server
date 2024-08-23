<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Client;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'zip_code',
        'state',
        'city',
        'street',
        'neighborhood',
        'additional_information',
        'client_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function client(): BelongsTo
    {
        return $this->belongTo(Client::class);
    }
}
