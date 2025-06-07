<?php

namespace App\Console\Commands;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanOldMessages extends Command
{
    protected $signature = 'messages:clean {--days=30}';
    protected $description = 'Limpiar mensajes antiguos';

    public function handle()
    {
        $days = $this->option('days');
        $date = Carbon::now()->subDays($days);

        $count = Message::where('created_at', '<', $date)->count();

        if ($this->confirm("¿Eliminar {$count} mensajes de más de {$days} días?")) {
            Message::where('created_at', '<', $date)->delete();
            $this->info("Se eliminaron {$count} mensajes.");
        }
    }
}
