<?php

namespace LechugaNegra\PrivKeyManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use LechugaNegra\PrivKeyManager\Models\PrivKeyGroup;
use LechugaNegra\PrivKeyManager\Models\PrivKeyGroupRoute;

class AddRouteToPrivKeyGroup extends Command
{
    protected $signature = 'privkey:group:add-route
                            {--group= : Nombre del grupo}
                            {--route= : Nombre (alias) de la ruta Laravel}';

    protected $description = 'Agrega una ruta a un grupo de acceso';

    public function handle()
    {
        $groupName = $this->option('group');
        $routeName = $this->option('route');

        if (!$groupName || !$routeName) {
            $this->error('Los parámetros --group y --route son obligatorios.');
            return 1;
        }

        $group = PrivKeyGroup::where('name', $groupName)->first();

        if (!$group) {
            $this->error("No existe un grupo con el nombre \"{$groupName}\".");
            return 1;
        }

        if (!Route::has($routeName)) {
            $this->error("No existe una ruta con el alias \"{$routeName}\".");
            return 1;
        }

        if (PrivKeyGroupRoute::where('priv_key_group_id', $group->id)->where('route_name', $routeName)->exists()) {
            $this->error("La ruta \"{$routeName}\" ya está asignada al grupo \"{$groupName}\".");
            return 1;
        }

        $route = PrivKeyGroupRoute::create([
            'priv_key_group_id' => $group->id,
            'route_name'        => $routeName,
        ]);

        $this->info('Ruta agregada exitosamente:');
        $this->line('');
        $this->line("  ID         : {$route->id}");
        $this->line("  Group      : {$group->name}");
        $this->line("  Route      : {$route->route_name}");
        $this->line("  Created At : {$route->created_at}");
        $this->line('');
    }
}
