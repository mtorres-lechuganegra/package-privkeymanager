<?php

namespace LechugaNegra\PrivKeyManager\Console\Commands;

use Illuminate\Console\Command;
use LechugaNegra\PrivKeyManager\Models\PrivKeyGroup;

class CreatePrivKeyGroup extends Command
{
    protected $signature = 'privkey:group:create
                            {--name= : Nombre del grupo}
                            {--description= : Descripción del grupo}';

    protected $description = 'Crea un nuevo grupo de acceso para API Keys';

    public function handle()
    {
        $name = $this->option('name');

        if (!$name) {
            $this->error('El nombre del grupo es obligatorio.');
            return 1;
        }

        if (PrivKeyGroup::where('name', $name)->exists()) {
            $this->error("Ya existe un grupo con el nombre \"{$name}\".");
            return 1;
        }

        $group = PrivKeyGroup::create([
            'name'        => $name,
            'description' => $this->option('description'),
        ]);

        $this->info('Grupo creado exitosamente:');
        $this->line('');
        $this->line("  ID         : {$group->id}");
        $this->line("  Name       : {$group->name}");
        $this->line("  Description: " . ($group->description ?? 'Sin descripción'));
        $this->line("  Created At : {$group->created_at}");
        $this->line('');
    }
}
