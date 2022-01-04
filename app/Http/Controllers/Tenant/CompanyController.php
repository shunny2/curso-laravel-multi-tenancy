<?php

namespace App\Http\Controllers\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {
        $company = $this->company->create([
            'name' => 'EmpresaX' . Str::random(3),
            'domain' => Str::random(3) . 'empresax_domain_org',
            'bd_database' => 'empresax_db_org' . Str::random(3),
            'bd_hostname' => 'mysql',
            'bd_username' => 'root',
            'bd_password' => 'root',
        ]);

        //Se o checkbox marcado for true crio um novo database.
        if(true)
            //Chamando o evento para criar a database para a determinada compania.
            event(new CompanyCreated($company));
        else
            //Chamando o evento para criar as tabelas.
            event(new DatabaseCreated($company));

        dd($company);
    }
}
