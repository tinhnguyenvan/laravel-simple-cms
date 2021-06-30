<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassifiedCategory extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classified_categories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'image_id',
        'image_url',
        'detail',
        'creator_id',
        'editor_id',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'level',
        'order_by',
        'status',
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

    public function getLinkAttribute()
    {
        $prefix = config('constant.URL_PREFIX_CLASSIFIED');

        return base_url($prefix . '/' . $this->slug);
    }

    public function parent()
    {
        return $this->belongsTo(ClassifiedCategory::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(ClassifiedCategory::class, 'id', 'parent_id');
    }
}
