<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function transactions (): HasMany {
        return(
            $this->hasMany(
                \App\Models\Transaction::class,
                'in_category_id'
            )
        );
    }
}
