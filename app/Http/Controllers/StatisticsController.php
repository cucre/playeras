<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InventoryDetail;

class StatisticsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:Administrador');
    }
    
    public function index()
    {
        $year = request()->has('year') ? request()->year : date('Y');
        $inventory = InventoryDetail::whereYear('created_at', '=', $year)
            ->with('product')
            ->get();

        $monthly = $inventory
            ->map(function($i){
                $i->month = $this->month($i->created_at->format('m'));
                return $i;
            })
            ->groupBy('month')
            ->map(function($i){
                return $i
                    ->groupBy('movement_type')
                    ->map(function($i,$k){
                        if($k == 'DEVOLUCIÓN'){
                            return [
                                'ENTRADA' => $i->sum(function($i){
                                    return 0;//$i->quantity * $i->product->purchase_price;
                                }),
                                'SALIDA'  => $i->sum(function($i){
                                    return $i->quantity * $i->product->selling_price;
                                }),
                            ];
                        }else{
                            return $i->transform(function($i){
                                switch($i->movement_type){ 
                                    case 'ENTRADA':
                                        $value = $i->product->purchase_price;
                                        break;
                                    case 'SALIDA':
                                        if($i->sale_type == 'VENDEDOR'){
                                            $value = $i->product->selling_price;
                                        }else{
                                            $value = $i->product->customer_price;
                                        }
                                    
                                }
                                return $i->quantity * $value;
                            })->sum();
                        }
                    });
                    
            })
            ;
        
        $inventory = $inventory->groupBy('movement_type');

        if(isset($inventory['SALIDA'])){
            $sum = $inventory['SALIDA']->where('sale_type','VENDEDOR')
                ->map(function($i){
                    return [
                        'invertido' => $i->quantity * $i->product->purchase_price,
                        'vendido'   => $i->quantity * $i->product->selling_price,
                    ];
                });

            $totalVendedor = [
                'invertido' => $sum->sum('invertido'),
                'vendido' => $sum->sum('vendido'),
            ];

            $sum = $inventory['SALIDA']->where('sale_type','DIRECTA')
                ->map(function($i){
                    return [
                        'invertido' => $i->quantity * $i->product->purchase_price,
                        'vendido'   => $i->quantity * $i->product->customer_price,
                    ];
                });

            $totalDirecto = [
                'invertido' => $sum->sum('invertido'),
                'vendido' => $sum->sum('vendido'),
            ];
        }else{
            $totalVendedor = [
                'invertido' => 0,
                'vendido'   => 0,
            ];

            $totalDirecto = [
                'invertido' => 0,
                'vendido'   => 0,
            ];
        }

        $porcentaje = [
            'vendedores' => (($totalVendedor['vendido'] + $totalDirecto['vendido']) == 0) ? 0 : round(($totalVendedor['vendido'] * 100 ) / ($totalVendedor['vendido'] + $totalDirecto['vendido'])),
            'directo'    => (($totalVendedor['vendido'] + $totalDirecto['vendido']) == 0) ? 0 : round(($totalDirecto['vendido'] * 100 ) / ($totalVendedor['vendido'] + $totalDirecto['vendido'])),
        ];
        
        //dd($porcentaje);
        $devoluciones = [
            'ENTRADA' => 0,//$monthly->pluck('DEVOLUCIÓN')->sum('ENTRADA'),
            'SALIDA'  => -1 * $monthly->pluck('DEVOLUCIÓN')->sum('SALIDA')
        ];
        //dd($devoluciones);
        $inventory = $inventory
            ->filter(function($i,$k){ return $k != 'DEVOLUCIÓN'; })
            ->map(function($i,$k) use($devoluciones){
                return $i->transform(function($i){
                    return $i->quantity * $i->product->purchase_price;
                })->sum() + $devoluciones[$k];
            });
        //dd($inventory);
        
        //dd($inventory);
        $inventory['ENTRADA'] = isset($inventory['ENTRADA'])?$inventory['ENTRADA']:0;
        $inventory['SALIDA'] = isset($inventory['SALIDA'])?$inventory['SALIDA']:0;
        return \View::make('statistics')->with(compact('inventory','totalVendedor','totalDirecto','porcentaje','monthly','devoluciones'));
    }

    private function month($month)
    {
        $m = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        return $m[$month];
    }
}
