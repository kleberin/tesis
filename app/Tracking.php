<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tracking
 * @package App
 * @property int $id
 * @property int $user_id
 * @property Carbon $reportedAt
 * @property float $latitude
 * @property float $longitude
 * @property float $accuracy
 * @mixin Eloquent
 */
class Tracking extends Model
{
    protected $fillable = [
        'user_id',
        'reported_at',
        'latitude',
        'longitude',
        'accuracy'
    ];
}
