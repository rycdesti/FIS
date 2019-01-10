<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $description
 * @property string $disabled
 * @property string $disabled_date
 * @property string $disabled_by
 * @property string $logs
 * @property string $last_modified
 */
class AccountCategory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'financial.account_category';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['description', 'disabled', 'date_disabled', 'disabled_by', 'logs', 'last_modified'];


//    protected $dates = ['created_at', 'updated_at', 'date_disabled'];
}
