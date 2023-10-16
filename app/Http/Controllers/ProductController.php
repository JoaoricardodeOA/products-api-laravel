<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected function validationTreatment(Request $request){
        return $validator = Validator::make($request->all(),[
        'name' => 'required',
        'value' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'description' =>''
    ],[
        'name.required' => 'É necessário um nome.',
        'value.required' => 'É necessário um valor.',
        'value.numeric' => 'Valor deve ser numérico.',
        'value.min' => 'Valor deve não deve ser negativo.',
        'value.regex' => 'Valor deve conter apenas duas casas decimais']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = $this->validationTreatment($request);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if($product){
            return $product;
        }
        return response()->json(['message'=> 'Produto não encontrado'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if($product){
            $validator = $this->validationTreatment($request);
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->first()], 400);
            }
            $product->update($request->all());
            return $product;
        } 
        return response()->json(['message'=> 'Produto não encontrado'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product){
            Product::destroy($id);
            return response()->json(['message'=> 'produto excluído com sucesso'], 200);
        }
        
        return response()->json(['message'=> 'Produto não encontrado'], 404);

    }
}
