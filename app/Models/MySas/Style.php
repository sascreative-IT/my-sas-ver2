<?php

namespace App\Models\MySas;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $connection = 'mysas';

    public function sports()
    {
        return $this->belongsToMany(Sport::class,'style_sports','style_id','sport_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'style_sizes','style_id','size_id');
    }

    public function styleFactories()
    {
        return $this->belongsToMany(Factory::class,'style_factories','style_id','factory_id');
    }

    public function embellishments()
    {
        return $this->belongsToMany(EmbellishmentType::class,'style_embellishments','style_id','embellishment_type_id');
    }

    public function components()
    {
        return $this->hasMany(StyleComponent::class);
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
