<?php

namespace App\Models\google;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\users\Admin;
use Illuminate\Database\Eloquent\Model;

class GoogleTokens extends Model
{
    use HasFactory;
    protected $table = 'google_tokens';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'user_id',
        'access_token',
        'refresh_token',
        'scope',
        'expire_date',
    ];
    public $timestamps = true;

    // Relasi ke admin (one to one)
    public function adminToken() {
        return $this->belongsTo(Admin::class, 'user_id', 'user_id');
    }
}
