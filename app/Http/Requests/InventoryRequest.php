<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        if($this->movement_type == 'SALIDA') {
            if($this->sale_type == 'VENDEDOR') {
                return [
                    'sku'           => 'required|max:255|exists:products,sku',
                    'movement_type' => 'required',
                    'sale_type'     => 'required',
                    'vendedor_id'   => 'required',
                    'quantity'      => 'required|integer|check_stock:inventory_summaries,product_id,'. $this->quantity .','. $this->product_id,
                ];
            } else {
                return [
                    'sku'           => 'required|max:255|exists:products,sku',
                    'movement_type' => 'required',
                    'sale_type'     => 'required',
                    'quantity'      => 'required|integer|check_stock:inventory_summaries,product_id,'. $this->quantity .','. $this->product_id,
                ];
            }
        } if($this->movement_type == 'DEVOLUCIÓN') {
            return [
                'sku'           => 'required|max:255|exists:products,sku',
                'movement_type' => 'required',
                'vendedor_id'   => 'required',
                'quantity'      => 'required|integer',
            ];
        } else {
            return [
                'sku'           => 'required|max:255|exists:products,sku',
                'movement_type' => 'required',
                'quantity'      => 'required|integer',
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'required'          => 'El campo :attribute es obligatorio.',
            'max'               => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'integer'           => 'El campo :attribute debe ser un número entero.',
            'check_stock'       => 'No hay unidades suficientes para la venta.',
            'exists'            => ':attribute es inválido.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'sku'              => 'SKU',
            'movement_type'    => 'Tipo',
            'sale_type'        => 'Tipo de venta',
            'quantity'         => 'Cantidad',
            'vendedor_id'      => 'Vendedor',
        ];
    }
}