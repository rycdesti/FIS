<?php

namespace App\Models\Ap;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $bank_code
 * @property string $bank_name
 * @property string $bank_prefix
 * @property string $disabled
 * @property string $date_disabled
 * @property string $disabled_by
 * @property string $logs
 * @property string $last_modified
 * @property string $created_at
 * @property string $updated_at
 */
class Bank extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ap.bank';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['bank_code', 'bank_name', 'bank_prefix', 'disabled', 'date_disabled', 'disabled_by', 'logs', 'last_modified', 'created_at', 'updated_at'];

    protected $dates = ['created_at', 'updated_at', 'date_disabled'];
}
