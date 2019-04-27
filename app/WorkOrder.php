<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkOrder
 * @package App
 * @property int $id
 * @property int $customer_id
 * @property Customer $customer
 * @property string $description
 * @property string $status
 * @property Carbon $date
 * @property int $user_id
 */
class WorkOrder extends Model
{
    //
    protected $fillable = [
        'id',
        'customer_id',
        'description',
        'status',
        'date',
        'user_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
