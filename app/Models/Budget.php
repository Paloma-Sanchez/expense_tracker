<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    /** @use HasFactory<\Database\Factories\BudgetFactory> */
    use HasFactory;

    protected $fillable =  ['name', 'budget_amount', 'by_user_id'];

    public function owner(): BelongsTo {
        return $this->belongsTo(
            \App\Models\User::class,
            'by_user_id'
        );
    } 

    public function transactions():HasMany {
        return(
            $this->hasMany(
                \App\Models\Transaction::class,
                'in_budget_id'
            )
            );
    }
}
