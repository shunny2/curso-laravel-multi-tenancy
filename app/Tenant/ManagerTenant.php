<?php

namespace App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{
    //Seta a conexão dinamicamente.
    public function setConnection(Company $company)
    {
        //Remove os dados de conexão que estão abertos por padrão.
        DB::purge('tenant');

        //Alterando as novas configurações do arquivo database.
        config()->set('database.connections.tenant.host', $company->bd_hostname);
        config()->set('database.connections.tenant.database', str_replace('.', '_', $company->bd_database));
        config()->set('database.connections.tenant.username', $company->bd_username);
        config()->set('database.connections.tenant.password', $company->bd_password);

        //Reconectando as novas configurações.
        DB::reconnect('tenant');

        //Testa a conexão.
        Schema::connection('tenant')->getConnection()->reconnect();
    }

    //Verifica se é o dominio principal.
    public function doMainIsMain()
    {
        return request()->getHost() == config('tenant.domain_main');
    }
}
