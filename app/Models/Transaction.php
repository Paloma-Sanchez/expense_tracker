<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable =  ['description', 'amount', 'in_category_id', 'in_budget_id', 'owner_id'];

    public function budget():BelongsTo {
        return(
            $this->belongsTo(
                \App\Models\Budget::class,
                'in_budget_id'
            )
        );
    }

    public function category():BelongsTo {
        return(
            $this->belongsTo(
                \App\Models\Category::class,
                'in_category_id'
            )
        );
    }

    public function owner():BelongsTo {
        return(
            $this->belongsTo(
                \App\Models\User::class,
                'owner_id'
            )
            );
    }
}
