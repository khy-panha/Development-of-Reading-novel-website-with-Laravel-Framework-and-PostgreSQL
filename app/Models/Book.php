<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   use HasFactory;
   public function comments(){
    return $this ->hasMany(Comment::class);
    
   }
    public function stories()
    {
        return $this->hasMany(Story::class);
    }
    public function averageRating()
    {
        $avg = $this->comments()->where('rating', '>', 0)->avg('rating');
        return round($avg, 1); // Calculate the average rating from all reviews
    }
        public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function views()
    {
        return $this->hasMany(Views::class);
    }
    
    public function totalViews()
{
    // Sum views from all related stories + direct book views (optional)
    // Assuming views for stories only:
    return Views::whereIn('story_id', $this->stories->pluck('id'))->count();
}
}
