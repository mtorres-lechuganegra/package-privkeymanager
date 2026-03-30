<?php

namespace LechugaNegra\PrivKeyManager\Models;

use Illuminate\Database\Eloquent\Model;

class PrivKeyGroupRoute extends Model
{
    protected $fillable = [
        'priv_key_group_id', 'route_name'
    ];

    public function group()
    {
        return $this->belongsTo(PrivKeyGroup::class, 'priv_key_group_id');
    }
}
