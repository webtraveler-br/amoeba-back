<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Mensagem;
use App\Http\Controllers\API\BaseController as BaseController;

class MensagemController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255',
            'email' => 'required|email',
            'assunto' => 'required|max:500',
            'mensagem' => 'required|max:500',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de Validação', $validator->errors());
        }

        $mensagem = Mensagem::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'assunto' => $request->assunto,
            'mensagem' => $request->mensagem,
        ]);

        $mensagem->save();
        return $this::enviarRespostaSucesso($mensagem, 'Mensagem criada',200);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|'
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erros de validação', $validator->errors());
        }

        $mensagem = Mensagem::find($request->id);
        if (!$mensagem)
        {
            return $this::enviarRespostaErro($mensagem, 'Mensagem não encontrada', 201);
        }

        return $this::enviarRespostaSucesso($mensagem,  'Mensagem encontrada', 200);
    }

    public function index(Request $request)
    {
        $mensagem = Mensagem::all();
        if (!$mensagem)
        {
            return $this::enviarRespostaErro('Mensagem não encontrada', 201);
        }
        return $this::enviarRespostaSucesso($mensagem, 'Mensagems encontradas', 200);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de validação', $validator->errors());
        }

        $mensagem = Mensagem::find($request->id);
        if (!$mensagem)
        {
            return $this::enviarRespostaErro($mensagem, 'Mensagem não encontrada', 201);
        }

        $mensagem->delete();

        return $this::enviarRespostaSucesso($mensagem, 'Mensagem deletada', 200);
    }
}
