<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {
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
        $this->product = mb_strtoupper($this->product);
        $ignore = '';
        $path_image_required = 'required|';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('product')->sku;
            $path_image_required = '';
        }

        return [
            'product'           => 'required|max:255',
            'sku'               => 'required|unique_unsensitive:products,sku'. $ignore,
            'brand_id'          => 'required',
            'color_id'          => 'required',
            'talla_id'          => 'required',
            'gender'            => 'required',
            'description'       => 'required',
            'purchase_price'    => 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'selling_price'     => 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'customer_price'    => 'required|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'path_image'        => $path_image_required .'file|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'required'                  => 'El campo :attribute es obligatorio.',
            'max'                       => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'unique_unsensitive'        => 'El campo :attribute ya existe.',
            'regex'                     => 'El formato del campo :attribute es inválido.',
            'file'                      => 'El campo :attribute debe ser una imagen.',
            'mimes'                     => 'El campo :attribute debe ser un archivo con formato: :values.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'product'           => 'Producto',
            'sku'               => 'SKU',
            'brand_id'          => 'Marca',
            'color_id'          => 'Color',
            'talla_id'          => 'Talla',
            'gender'            => 'Género',
            'description'       => 'Descripción',
            'purchase_price'    => 'Precio de compra',
            'selling_price'     => 'Precio de vendedor',
            'customer_price'    => 'Precio de cliente',
            'path_image'        => 'Imagen',
        ];
    }
}