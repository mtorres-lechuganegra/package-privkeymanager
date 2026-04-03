<?php

namespace LechugaNegra\PrivKeyManager\Console\Commands;

use Illuminate\Console\Command;
use LechugaNegra\PrivKeyManager\Models\PrivKey;
use LechugaNegra\PrivKeyManager\Models\PrivKeyGroup;

class AssignGroupToPrivKey extends Command
{
    protected $signature = 'privkey:key:assign-group
                            {--key= : API Key de 64 caracteres}
                            {--group= : Nombre del grupo}';

    protected $description = 'Asigna un grupo de acceso a una API Key';

    public function handle()
    {
        $keyValue  = $this->option('key');
        $groupName = $this->option('group');

        if (!$keyValue || !$groupName) {
            $this->error('Los parámetros --key y --group son obligatorios.');
            return 1;
        }

        $privKey = PrivKey::where('key', $keyValue)->first();

        if (!$privKey) {
            $this->error('No existe una API Key con ese valor.');
            return 1;
        }

        if ($privKey->isUnrestricted()) {
            $this->warn('Esta key es de tipo "unrestricted" — no necesita grupos asignados.');
            return 0;
        }

        $group = PrivKeyGroup::where('name', $groupName)->first();

        if (!$group) {
            $this->error("No existe un grupo con el nombre \"{$groupName}\".");
            return 1;
        }

        if ($privKey->groups()->where('priv_key_group_id', $group->id)->exists()) {
            $this->error("El grupo \"{$groupName}\" ya está asignado a esta key.");
            return 1;
        }

        $privKey->groups()->attach($group->id);

        $this->info('Grupo asignado exitosamente:');
        $this->line('');
        $this->line("  Key        : {$privKey->key}");
        $this->line("  Type       : {$privKey->type}");
        $this->line("  Group      : {$group->name}");
        $this->line('');
    }
}
