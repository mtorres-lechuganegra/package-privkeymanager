<?php

namespace LechugaNegra\PrivKeyManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class PrivKey extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'key', 'expires_at', 'referer_url'
    ];

    public function getJWTIdentifier() { return $this->getKey(); }
    public function getJWTCustomClaims() { return []; }
}

// PrivKey::withTrashed()->get(); // Ver eliminados
// $privKey->restore(); // Restaurar eliminado
// $privKey->forceDelete(); // Eliminación física
