<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'is_public',
        'color_hex',
        'icon_url',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }
}
