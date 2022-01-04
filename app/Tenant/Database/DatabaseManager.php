<?php

namespace App\Tenant\Database;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public function createDatabase(Company $company)
    {
        $database = str_replace('.', '_', $company->bd_database);

        //Query para criar o banco de dados.
        return DB::statement("
            CREATE DATABASE {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ");
    }
}
