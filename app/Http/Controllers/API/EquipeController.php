<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Equipe;
use App\Imagem;



class EquipeController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome'=>'required|max:255',
            'descricao'=>'required|max:500',
            'cargo'=>'required|max:255',
            'facebook'=>'required|active_url',
            'linkedin'=>'required|active_url',
            'twitter'=>'required|active_url',
            'instagram'=>'required|active_url',
            'imagem_id'=>'required|integer',
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação', $validator->fails());
        }

        $equipe = new Equipe;
        $equipe->nome = $request->nome;
        $equipe->descricao = $request->descricao;
        $equipe->cargo = $request->cargo;
        $equipe->facebook = $request->facebook;
        $equipe->linkedin = $request->linkedin;
        $equipe->twitter = $request->twitter;
        $equipe->instagram = $request->instagram;
        $equipe->imagem_id = $request->imagem_id;
       

        $imagem = Imagem::find($request->imagem_id);
        if (!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada');
        }
       $equipe->imagem() ->associate($imagem)->save();
       
        return $this::enviarRespostaSucesso($equipe , 'Equipe criada', 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagem_id'=>'required|integer',
            'descricao'=>'required|max:500',
            'cargo'=>'required|max:255',
            'facebook'=>'active_url',
            'linkedin'=>'active_url',
            'twitter'=>'active_url',
            'id'=>'required|integer',
            'instagram'=>'active_url',
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação', $validator->fails());
        }

        $equipe = Equipe::find($request->id);
        if (!$equipe)
        {
            return $this::enviarRespostaErro($equipe, 'Equipe não encontrada', 201);
        }

        $imagem = Imagem::find($request->imagem_id);
        if (!$imagem)
        {
            return $this::enviarRespostaErro('Imagem não encontrada');
        }

        $equipe->update($request->all());
        $equipe->imagem()->associate($imagem)->save();
        return $this::enviarRespostaSucesso($equipe, 'Equipe atualizada!', 200);
    }

    public function index(Request $request)
    {
        $equipe = Equipe::all();
        
            return $this::enviarRespostaSucesso($equipe,'Equipes econtradas', 200);

    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação'. $validator->errors());
        }

        $equipe = Equipe::find($request->id);
        if(!$equipe)
        {
            return $this::enviarRespostaErro('Equipe não encontrada', $validator->errors());
        }

        return $this::enviarRespostaSucesso($equipe, 'Equipe encontrada', 200);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer', 
        ]);

        if ($validator->fails()) {
            return $this::enviarRespostaErro('Erro de validação'. $validator->errors());
        }

        $equipe = Equipe::find($request->id);
        if(!$equipe)
        {
            return $this::enviarRespostaErro('Equipe não encontrada', $validator->errors());
        }

        $equipe->delete();
        return $this::enviarRespostaSucesso($equipe, 'Equipe deletada com sucesso!', 200);
    }
}
