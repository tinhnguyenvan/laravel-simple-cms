<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ads extends Model
{
    use SoftDeletes;

    const TYPE_IMAGE = 1;
    const TYPE_HTML = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 2;
    const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_DISABLE,
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ads';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'title',
        'link',
        'type',
        'theme',
        'code',
        'views',
        'order_by',
        'creator_id',
        'editor_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * @return array
     */
    public static function dropDownStatus()
    {
        $data = self::STATUS_LIST;

        $html = [];
        foreach ($data as $value) {
            $html[$value] = trans('common.status.' . $value);
        }

        return $html;
    }

    /**
     * text status.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case self::STATUS_DISABLE:
                $text = trans('product.status.disable');
                break;
            case self::STATUS_ACTIVE:
                $text = trans('product.status.active');
                break;
            default:
                $text = '--';
                break;
        }

        return $text;
    }

    /**
     * color status.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case self::STATUS_DISABLE:
                $text = 'danger';
                break;
            case self::STATUS_ACTIVE:
                $text = 'success';
                break;
            default:
                $text = 'default';
                break;
        }

        return $text;
    }
}
