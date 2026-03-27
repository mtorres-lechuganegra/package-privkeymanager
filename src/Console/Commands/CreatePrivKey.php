<?php

namespace LechugaNegra\PrivKeyManager\Console\Commands;

use Illuminate\Console\Command;
use LechugaNegra\PrivKeyManager\Models\PrivKey;

class CreatePrivKey extends Command
{
    protected $signature = 'privkey:create
                            {--expires_at= : Fecha de expiración (formato: Y-m-d H:i:s)}
                            {--referer_url= : URL de referencia permitida}';

    protected $description = 'Crea un nuevo registro de API Key en la base de datos';

    public function handle()
    {
        $key = bin2hex(random_bytes(32)); // 64 caracteres hexadecimales

        $data = ['key' => $key];

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
        $this->line("  Expires At : " . ($privKey->expires_at ?? 'Sin expiración'));
        $this->line("  Referer URL: " . ($privKey->referer_url ?? 'Sin restricción'));
        $this->line("  Created At : {$privKey->created_at}");
        $this->line('');
    }
}