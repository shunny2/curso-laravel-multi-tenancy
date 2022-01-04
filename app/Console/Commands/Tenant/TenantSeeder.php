<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:seed {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Seeder Tenants';

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
        //Setando a conexão para empresa.
        $this->tenant->setConnection($company);

        $this->info("Connecting Company {$company->name}");

        //Chamando o comando migrate para rodar as migrations dos clientes.
        $command = Artisan::call('db:seed', [
            '--class' => 'TenantsTableSeeder'
        ]);

        if($command === 0) {
            $this->info("Seeder Success {$company->name}");
        }

        $this->info("End Connecting Company {$company->name}");
        $this->info('---------------------------------------');
    }
}
