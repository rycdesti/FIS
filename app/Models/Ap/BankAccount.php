<?php

namespace App\Models\Ap;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $bank_id
 * @property string $bank_code
 * @property string $bank_address
 * @property string $acct_code
 * @property string $acct_no
 * @property string $acct_type
 * @property string $currency
 * @property float $beginning_balance
 * @property string $asof
 * @property string $disabled
 * @property string $date_disabled
 * @property string $disabled_by
 * @property string $logs
 * @property string $last_modified
 * @property string $created_at
 * @property string $updated_at
 */
class BankAccount extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ap.bank_accounts';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['bank_id', 'bank_code', 'bank_address', 'acct_code', 'acct_no', 'acct_type', 'currency', 'beginning_balance', 'asof', 'disabled', 'date_disabled', 'disabled_by', 'logs', 'last_modified', 'created_at', 'updated_at'];

    protected $dates = ['created_at', 'updated_at', 'date_disabled'];

}
