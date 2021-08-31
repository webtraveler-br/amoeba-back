<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Arquivo;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class ArquivoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->enviarRespostaSucesso(Arquivo::latest()->get());
    }

    public function show(Arquivo $arquivo)
    {
        return response()->download(storage_path('app/' . $arquivo->caminho));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alt' => 'required|max:500',
            'nome' => 'required|max:500',
            'descricao' => 'required|max:500',
            'arquivo' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->enviarRespostaErro('Erros de validação.', $validator->errors());
        }

        $caminhoArquivo = Storage::putFile('arquivos', $request->file('arquivo'), 'public');
        $arrayDadosArquivo = array_merge($request->only(['alt', 'nome', 'descricao']), [ 'caminho' => $caminhoArquivo]);
        $arquivoCriado = Arquivo::create($arrayDadosArquivo);
        return $this->enviarRespostaSucesso($arquivoCriado, 'Arquivo criado', 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arquivo $arquivo)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arquivo $arquivo)
    {
        Storage::delete($arquivo->caminho);
        $arquivo->delete();
        return $this->enviarRespostaSucesso('Removido com sucesso');
    }
}
