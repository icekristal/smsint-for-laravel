<?php

namespace Icekristal\SmsintForLaravel\Models;

use Carbon\Carbon;
use Icekristal\SmsintForLaravel\Enums\SmsintTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $owner_type
 * @property integer $owner_id
 * @property integer $smsint_id
 * @property SmsInt $smsint
 * @property string $recipient
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SmsIntOwner extends Model
{
    use SoftDeletes;

    /**
     *
     * Name Table
     * @var string
     */
    protected $table = 'smsint_owner';


    protected $fillable = [
        'owner_type',
        'owner_id',
        'recipient',
        'smsint_id',
        'info',
    ];

    /**
     *
     * Mutation
     *
     * @var array
     */
    protected $casts = [
        'info' => 'object',
    ];

    /**
     *
     *
     * @return belongsTo
     */
    public function smsint(): belongsTo
    {
        return $this->belongsTo(SmsInt::class);
    }

    /**
     * @return MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
