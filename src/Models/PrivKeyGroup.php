<?php

namespace LechugaNegra\PrivKeyManager\Models;

use Illuminate\Database\Eloquent\Model;

class PrivKeyGroup extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function routes()
    {
        return $this->hasMany(PrivKeyGroupRoute::class, 'priv_key_group_id');
    }

    public function keys()
    {
        return $this->belongsToMany(
            PrivKey::class,
            'priv_key_group_assignments',
            'priv_key_group_id',
            'priv_key_id'
        );
    }
}
