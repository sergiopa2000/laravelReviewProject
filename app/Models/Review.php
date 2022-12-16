<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use VanOns\Laraberg\Traits\RendersContent;

class Review extends Model
{
    use HasFactory;
    use RendersContent;
        
    protected $table = 'review';
    protected $fillable = ['type', 'title', 'content', 'excerpt', 'idUser', 'featuredImage'];
    protected $contentColumn = 'content';
    
    public function type() {
        return $this->belongsTo('App\Models\Type', 'type');
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'idUser');
    }
    
    public function images() {
        return $this->hasMany('App\Models\Image', 'idReview');
    }
}
