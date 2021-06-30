<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use SoftDeletes;

    public const SOURCE_MALE = 1;
    public const SOURCE_FEMALE = 2;
    public const SOURCE_ORDER = 3;

    public const STATUS_ACTIVE = 1;
    public const STATUS_WAITING_ACTIVE = 3;
    public const STATUS_BLOCK = 5;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider',
        'provider_id',
        'username',
        'password',
        'fullname',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'status',
        'country_id',
        'city_id',
        'district_id',
        'ward_id',
        'birth_day',
        'birth_month',
        'birth_year',
        'birthday',
        'image_id',
        'image_url',
        'gender',
        'tags',
        'bio',
        'deleted_at',
        'created_at',
        'updated_at'
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
    protected $dates = ['birthday', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * text status.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case self::STATUS_BLOCK:
                $text = trans('member.status.block');
                break;
            case self::STATUS_WAITING_ACTIVE:
                $text = trans('member.status.waiting_active');
                break;
            case self::STATUS_ACTIVE:
                $text = trans('member.status.active');
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
            case self::STATUS_BLOCK:
                $text = 'danger';
                break;
            case self::STATUS_WAITING_ACTIVE:
                $text = 'warning';
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

    public function socials()
    {
        return $this->hasMany(MemberSocialAccount::class);
    }
}
