<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');

        //Verifica se o id foi informado.
        if ($id) {
            //Procura pelo id.
            $company = Company::find($id);

            if($company)
                $this->execCommand($company);

            return;
        }

        //Recuperando todas as empresas.
        $companies = Company::all();

        foreach ($companies as $company) {
            $this->execCommand($company);
        }
    }

    public function execCommand(Company $company)
    {
        //Verifica se a opção de refresh foi passada.
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        //Setando a conexão para empresa.
        $this->tenant->setConnection($company);

        $this->info("Connecting Company {$company->name}");

        //Chamando o comando migrate para rodar as migrations dos clientes.
        $run = Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/tenant'
        ]);

        if($run === 0) {
            $this->info("Migrations Success {$company->name}");
            Artisan::call('db:seed', [
                '--class' => 'TenantsTableSeeder'
            ]);
        }

        $this->info("End Connecting Company {$company->name}");
        $this->info('---------------------------------------');
    }
}
