<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property $id
 * @property $name
 * @property $content
 * @property $duration
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Course extends Model
{
    
    static $rules = [
		'name' => 'required',
		'content' => 'required',
		'duration' => 'required',
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','content','duration','user_id'];

    public function user(){
     return $this->belongsTo(User::class);
    }

    public function students(){
      return $this->belongsToMany(User::class)
                  ->withPivot('id','feedback')
                  ->withTimestamps();
      
    }

}
