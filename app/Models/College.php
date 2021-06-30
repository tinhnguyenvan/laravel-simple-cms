<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_DISABLE = 2;
    public const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_DISABLE,
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ps_colleges';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'member_id',
        'name',
        'slug',
        'phone',
        'email',
        'website',
        'address',
        'district_id',
        'district_name',
        'city_id',
        'city_name',
        'country_id',
        'country_name',
        'student_statistics_tuition',
        'student_statistics_dorm_fee',
        'student_statistics_total_student',
        'student_statistics_international_student',
        'image_id',
        'image_url',
        'cover_id',
        'cover_url',
        'views',
        'summary',
        'detail_general',
        'detail_applicant_eligibility',
        'detail_admission',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'status',
        'creator_id',
        'editor_id',
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
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public static function dropDownStatus()
    {
        $data = self::STATUS_LIST;

        $html = [];
        foreach ($data as $value) {
            $html[$value] = trans('college.status.' . $value);
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
                $text = trans('college.status.disable');
                break;
            case self::STATUS_ACTIVE:
                $text = trans('college.status.active');
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

    public function images()
    {
        return $this->hasMany(CollegeImage::class);
    }

    public function getLinkAttribute()
    {
        return base_url(config('constant.URL_PREFIX_COLLEGE') . '/' . $this->slug . '.html');
    }
}
