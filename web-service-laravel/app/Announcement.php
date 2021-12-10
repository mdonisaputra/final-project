<?php

namespace App;

use App\User;
use App\AnnounceComment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function announcecomment()
    {
        return $this->hasMany('App\AnnounceComment');
    } 
    
    protected $fillable = ['judul', 'deskripsi', 'file', 'user_id'];
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
