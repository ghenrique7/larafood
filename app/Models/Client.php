<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

}
