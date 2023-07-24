<?php

namespace Models;

use Carbon\Carbon;
use Enums\SmsintTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property object $recipients
 * @property SmsintTypeEnum $type
 * @property integer $cascade_id
 * @property string $message
 * @property boolean $is_validate
 * @property boolean $is_send
 * @property float|integer $price
 * @property string $name_send
 * @property string $send_url
 * @property object $info_send
 * @property object $info_answer
 * @property Carbon $start_send_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property SmsIntOwner[] $owners
 */
class SmsInt extends Model
{
    use SoftDeletes;

    /**
     *
     * Name Table
     * @var string
     */
    protected $table = 'smsint';


    protected $fillable = [
        'recipients',
        'type',
        'cascade_id',
        'message',
        'is_validate',
        'is_send',
        'price',
        'name_send',
        'send_url',
        'info_send',
        'info_answer',
        'start_send_at',
    ];

    /**
     *
     * Mutation
     *
     * @var array
     */
    protected $casts = [
        'type' => SmsintTypeEnum::class,
        'info_send' => 'object',
        'info_answer' => 'object',
        'recipients' => 'object',
        'start_send_at' => 'datetime',
        'is_send' => 'boolean',
        'is_validate' => 'boolean',
    ];

    /**
     * Relations
     */
    public function owners(): HasMany
    {
        return $this->hasMany(SmsIntOwner::class, 'smsint_id', 'id');
    }
}
