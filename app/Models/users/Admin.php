<?php

namespace App\Models\users;

use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\google\GoogleTokens;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticate
{
    use HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'user_id',
      'name',
      'email',
      'password',
      'avatar',
    ];
    public $timestamps = true;

    // Relasi ke google_tokens
    public function googleTokens() {
        return $this->hasOne(GoogleTokens::class, 'user_id', 'user_id');
    }
}
