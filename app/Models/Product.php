<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    protected $table = 'products';

    protected $fillable = [
        'title',
        'price',
        'description',
    ];

    public function categories()
	{
		return $this->belongsToMany(Category::class, 'product_has_category')
            ->withPivot('product_id');
	}
}
