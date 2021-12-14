<?php

namespace App\Models\MySas;

use Illuminate\Database\Eloquent\Model;

class LocalStyle extends Model
{
    protected $connection = 'mysas';


    public function sizes()
    {
        return $this->belongsToMany(Size::class,'local_style_sizes','local_style_id','size_id');
    }

    public function category()
    {
        return $this->belongsTo(StyleCategory::class, "style_category_id");
    }

    public function customer()
    {
        return $this->belongsTo(Client::class,"customer_id");
    }
}
