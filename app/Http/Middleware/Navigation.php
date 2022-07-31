<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Navigation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check()){

            \Session::put('Breadcrumbs',collect([
                'Registrar'      => 'create',
                'Configuración'  => 'config',
                'Editar'         => 'edit',
                'Codificación'   => 'codificacion',
                'Administración' => 'admin',
                'Principal'      => 'home',
                'Estadísticas'    => 'estadisticas',

            ]));

            \Session::put('Navigation',$this->menu());

        }

        return $next($request);

    }

    private function menu(){
        $url = str_replace(url('/'),'',url()->current());

        $menu['Estadísticas'] = [
            'url'     => route('statistics.index'),//route('home'),
            'active'  => (strpos($url,str_replace(url('/'),'','/estadisticas')) !== false)?'active':'',
            'icon'    => 'fas fa-money-bill-alt',
        ];

        if(auth()->user()->hasAnyRole(['Administrador'])){
            $menu['Configuración'] = [
                'url'     => 'javascript:;',
                'active'  => (strpos($url,str_replace(url('/'),'','/config')) !== false)?'active':'',
                'icon'    => 'fas fa-cogs',
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Usuarios',
                'url'    => route('usuarios.index'),
                'icon'   => 'fas fa-users',
                'active' => (strpos($url,str_replace(url('/'),'','/usuarios')) !== false)?'active':''
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Permisos',
                'url'    => route('permisos.index'),
                'icon'   => 'fas fa-id-card',
                'active' => (strpos($url,str_replace(url('/'),'','/permisos')) !== false)?'active':''
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Marcas',
                'url'    => route('marcas.index'),
                'icon'   => 'fas fa-copyright',
                'active' => (strpos($url, str_replace(url('/'), '', '/marcas')) !== false) ? 'active' : ''
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Colores',
                'url'    => route('colores.index'),
                'icon'   => 'fas fa-paint-brush',
                'active' => (strpos($url,str_replace(url('/'),'','/colores')) !== false)?'active':''
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Tallas',
                'url'    => route('tallas.index'),
                'icon'   => 'fas fa-expand',
                'active' => (strpos($url,str_replace(url('/'),'','/tallas')) !== false)?'active':''
            ];

            $menu['Configuración']['submenu'][] =  [
                'name'   => 'Productos',
                'url'    => route('productos.index'),
                'icon'   => 'fab fa-product-hunt',
                'active' => (strpos($url, str_replace(url('/'),'','/productos')) !== false) ? 'active' : ''
            ];

            $menu['Inventario'] = [
                'name'   => 'Inventario',
                'url'    => route('inventario.index'),
                'active'  => (strpos($url, str_replace(url('/'), '', '/inventario')) !== false) ? 'active' : '',
                'icon'    => 'fas fa-list-alt',
            ];

        }

        return $menu;
    }
}