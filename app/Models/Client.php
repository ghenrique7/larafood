<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

}
