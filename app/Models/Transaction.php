<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function __construct()
    {
        $this->date_transaction = now();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'montant',
        'destination_iban',
        'user_id',
        'type',
        'date_transaction',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}