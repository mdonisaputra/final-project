<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class AnnounceComment extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function announce()
    {
        return $this->belongsTo('App\Announcement');
    }
   
    protected $fillable = ['isi', 'announcement_id', 'user_id'];
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
