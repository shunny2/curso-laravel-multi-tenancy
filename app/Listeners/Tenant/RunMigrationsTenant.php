<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\DatabaseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RunMigrationsTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Tenant\DatabaseCreated  $event
     * @return void
     */
    public function handle(DatabaseCreated $event)
    {
        $company = $event->company();

        //Roda a migration cujo for igual ao id da empresa.
        $migration = Artisan::call('tenants:migrations', [
            'id' => $company->id,
        ]);

        /*
        //Se a tabela tiver sido criada, será criado um usuário na tabela dos clientes.
        if ($migration == 0)
            Artisan::call('db:seed', [
                '--class' => 'TenantsTableSeeder'
            ]);
        */
        return $migration === 0;
    }
}
