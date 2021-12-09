<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function news()
    {
        return $this->belongsTo('App\News');
    }
   
    protected $fillable = ['isi', 'new_id', 'user_id'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot(){
        parent::boot();
        static::creating(function ($model){
            if (empty($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()} = Str::uuid();
            }

            $model->user_id = auth()->user()->id;
        });
    }
}
