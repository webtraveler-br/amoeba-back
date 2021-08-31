<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Storage;
use App\Contato;

class ContatosController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'endereco' => 'required|max:500',
            'email' => 'required|email',
            'telefone' => 'required|max:500',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de validação', $validator->errors());
        }

        $contato = Contato::create([
            'endereco' => $request->endereco,
            'email' => $request->email,
            'telefone' => $request->telefone,
        ]);

        return $this::enviarRespostaSucesso($contato, 'Contato Criado com Sucesso', 200);
    }


    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de Validação', $validator->errors());
        }

        $contato = Contato::find($request->id);
        if (!$contato)
        {
            return $this::enviarRespostaErro('Contatos não encontrados', 201);
        }

        return $this::enviarRespostaSucesso($contato, 'Contato Encontrado com Sucesso', 200);

    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de Validação', $validator->errors());
        }

        $contato = Contato::find($request->id);
        if (!$contato)
        {
            return $this::enviarRespostaErro('Contato não encontrado');
        }
        
        $contato->delete();

        return $this::enviarRespostaSucesso('Contato deletado com sucesso', 200);

    }

    public function index(Request $request)
    {
        $contato = Contato::all();
            return $this::enviarRespostaSucesso($contato, 'Contatos mostados com sucesso', 200);
        

    
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
            'endereco' => 'required|max:500',
            'email' =>'required|email',
            'telefone' => 'required|max:500',
        ]);

        if ($validator->fails())
        {
            return $this::enviarRespostaErro('Erro de Validação');
        }

        $contato = Contato::find($request->id);
        if(!$contato)
        {
            return $this::enviarRespostaErro('Contato não encontrado');
        }

        
        $contato->endereco = $request->endereco;
        $contato->email = $request->email;
        $contato->telefone = $request->telefone;
        $contato->save();

        return $this::enviarRespostaSucesso($contato, 'Contato alterado com Sucesso', 200);

    }

}
