<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    public function products()
	{
		return $this->belongsToMany(Product::class, 'product_has_category')
            ->withPivot('category_id', 'status');
	}
}
