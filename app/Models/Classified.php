<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classified extends Model
{
    use SoftDeletes;

    public const SOURCE_INTERNAL = 0;
    public const SOURCE_MUA_BAN = 1;

    public const STATUS_ACTIVE = 1;
    public const STATUS_DISABLE = 2;
    public const STATUS_WAITING_APPROVED = 3;
    public const STATUS_EXPIRED = 4;
    public const STATUS_SOLD = 5;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_DISABLE,
        self::STATUS_WAITING_APPROVED,
        self::STATUS_EXPIRED,
        self::STATUS_SOLD,
    ];

    public const STATUS_LIST_CODE = [
        self::STATUS_ACTIVE => 'active',
        self::STATUS_DISABLE => 'disable',
        self::STATUS_WAITING_APPROVED => 'waiting_approved',
        self::STATUS_EXPIRED => 'expired',
        self::STATUS_SOLD => 'sold',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classifieds';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'member_id',
        'category_id',
        'category_name',
        'title',
        'slug',
        'district_id',
        'district_name',
        'city_id',
        'city_name',
        'image_id',
        'image_url',
        'image_url_thumb',
        'images_multi',
        'is_sale',
        'is_company',
        'price',
        'price_unit',
        'detail',
        'views',
        'creator_id',
        'editor_id',
        'started_at',
        'expired_at',
        'contact_fullname',
        'contact_email',
        'contact_phone',
        'contact_address',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'status',
        'source_id',
        'source',
        'created_at',
        'updated_at',
        'deleted_at'
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
    protected $casts = [
        'price' => 'double',
        'is_sale' => 'boolean',
        'is_company' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'expired_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function dropDownStatus()
    {
        $data = self::STATUS_LIST;
        $code = self::STATUS_LIST_CODE;

        $html = [];
        foreach ($data as $value) {
            $html[$value] = trans('classified.status.' . $code[$value]);
        }

        return $html;
    }

    /**
     * color status.
     *
     * @return string
     */
    public function getPriceFormatAttribute()
    {
        $text = '--';
        if ($this->price > 0) {
            $text = number_format($this->price);
        }

        return $text;
    }

    public function getLinkAttribute()
    {
        $prefix = config('constant.URL_PREFIX_CLASSIFIED') . '/';

        $prefix .= $this->category->slug ?? 'no-category';

        return base_url($prefix . '/' . $this->slug . '+' . $this->id . '.html');
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
                $text = trans('classified.status.disable');
                break;
            case self::STATUS_ACTIVE:
                $text = trans('classified.status.active');
                break;
            case self::STATUS_WAITING_APPROVED:
                $text = trans('classified.status.waiting_approved');
                break;
            case self::STATUS_EXPIRED:
                $text = trans('classified.status.expired');
                break;
            case self::STATUS_SOLD:
                $text = trans('classified.status.sold');
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
                $text = 'black';
                break;
            case self::STATUS_ACTIVE:
                $text = 'success';
                break;
            case self::STATUS_WAITING_APPROVED:
                $text = 'warning';
                break;
            case self::STATUS_EXPIRED:
                $text = 'danger';
                break;
            case self::STATUS_SOLD:
            default:
                $text = 'default';
                break;
        }

        return $text;
    }

    public function images()
    {
        return $this->hasMany(ClassifiedImage::class);
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ClassifiedCategory::class, 'category_id', 'id');
    }
}
