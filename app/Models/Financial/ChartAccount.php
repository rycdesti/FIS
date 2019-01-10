<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class ChartAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'financial.chart_accounts';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['acct_code', 'description', 'disabled', 'date_disabled', 'disabled_by', 'last_modified', 'logs', 'category_id', 'posting_type', 'typical_balance'];

    protected $dates = ['created_at', 'updated_at', 'date_disabled'];
}
