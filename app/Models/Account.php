<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'solde',
        'iban',
        'user_id',
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
