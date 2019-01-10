<?php

namespace App\Models\Ap;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $acct_no
 * @property string $check_from
 * @property string $check_to
 * @property string $check_no
 * @property string $voucher_no
 * @property string $logs
 * @property string $last_modified
 * @property string $is_disabled
 * @property string $reason
 * @property string $created_at
 * @property string $updated_at
 */
class Check extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ap.checks';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['acct_no', 'check_from', 'check_to', 'check_no', 'voucher_no', 'logs', 'last_modified', 'is_disabled', 'reason', 'created_at', 'updated_at'];

    function scopeGroupCheck($query)
    {
        return $query
            ->groupBy('check_from')
            ->groupBy('check_to')
            ->groupBy('logs')
            ->groupBy('created_at')
            ->groupBy('acct_no');
    }
}
