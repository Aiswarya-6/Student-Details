<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory , SoftDeletes;

    /**
     * The table relationships name change from snake_case to camelCase.
     *
     * @var string
     */
    public static $snakeAttributes = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stateName',
        'countryId'
    ];
}
