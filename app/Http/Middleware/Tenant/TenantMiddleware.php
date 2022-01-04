<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $manager = app(ManagerTenant::class);

        if ($manager->doMainIsMain())
            return $next($request);

        $company = $this->getCompany($request->getHost()); //Pegando a compania vindo do request.

        //Se a companhia nao existir, verifica se a rota atual e diferente de 404.
        if(!$company && $request->url() != route('404.tenant')) {
            // return redirect()->route('404.tenant');
            abort(404,'Dominio não encontrado!');
        }else if($request->url() != route('404.tenant') && !$manager->doMainIsMain()) {
            $manager->setConnection($company);

            $this->setSessionCompany($company->only([
                'name', 'uuid'
            ]));
        }

        return $next($request);
    }

    //Método para verificar se a compania existe.
    public function getCompany($host)
    {
        return Company::where('domain', $host)->first();
    }

    //Criando uma nova sessão.
    public function setSessionCompany($company)
    {
        session()->put('company', $company);
    }
}
