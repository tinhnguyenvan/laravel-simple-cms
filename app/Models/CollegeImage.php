<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeImage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ps_college_images';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'college_id',
        'image_id',
        'image_url',
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
}
