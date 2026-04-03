<?php

namespace LechugaNegra\PrivKeyManager\Console\Commands;

use Illuminate\Console\Command;
use LechugaNegra\PrivKeyManager\Models\PrivKey;

class CreatePrivKey extends Command
{
    protected $signature = 'privkey:create
                            {--type=restricted : Tipo de llave (restricted|unrestricted)}
                            {--expires_at= : Fecha de expiración (formato: Y-m-d H:i:s)}
                            {--referer_url= : URL de referencia permitida}';

    protected $description = 'Crea un nuevo registro de API Key en la base de datos';

    public function handle()
    {
        $type = $this->option('type');

        if (!in_array($type, ['restricted', 'unrestricted'])) {
            $this->error('El tipo debe ser "restricted" o "unrestricted".');
            return 1;
        }

        $key = bin2hex(random_bytes(32)); // 64 caracteres hexadecimales

        $data = [
            'key'  => $key,
            'type' => $type,
        ];

        if ($this->option('expires_at')) {
            $data['expires_at'] = $this->option('expires_at');
        }

        if ($this->option('referer_url')) {
            $data['referer_url'] = $this->option('referer_url');
        }

        $privKey = PrivKey::create($data);

        $this->info('API Key creada exitosamente:');
        $this->line('');
        $this->line("  Key        : {$privKey->key}");
        $this->line("  Type       : {$privKey->type}");
        $this->line("  Expires At : " . ($privKey->expires_at ?? 'Sin expiración'));
        $this->line("  Referer URL: " . ($privKey->referer_url ?? 'Sin restricción'));
        $this->line("  Created At : {$privKey->created_at}");
        $this->line('');
    }
}