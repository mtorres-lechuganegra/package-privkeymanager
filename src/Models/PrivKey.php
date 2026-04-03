<?php

namespace LechugaNegra\PrivKeyManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class PrivKey extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'key', 'type', 'expires_at', 'referer_url'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isUnrestricted(): bool
    {
        return $this->type === 'unrestricted';
    }

    public function isRestricted(): bool
    {
        return $this->type === 'restricted';
    }

    public function groups()
    {
        return $this->belongsToMany(
            PrivKeyGroup::class,
            'priv_key_group_assignments',
            'priv_key_id',
            'priv_key_group_id'
        );
    }
}

// PrivKey::withTrashed()->get(); // Ver eliminados
// $privKey->restore(); // Restaurar eliminado
// $privKey->forceDelete(); // Eliminación física
