<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * Códigos HTTP que podem ser usados
     *
     * Sucesso:
     * 200 – OK – Eyerything is working
     * 201 – OK – New resource has been created
     * 204 – OK – The resource was successfully deleted
     *
     * Erro:
     * 400 – Bad Request – The request was invalid or cannot be served. The exact error should be explained in the error payload. E.g. „The JSON is not valid“
     * 401 – Unauthorized – The request requires an user authentication
     * 403 – Forbidden – The server understood the request, but is refusing it or the access is not allowed.
     * 404 – Not found – There is no resource behind the URI.
     * 422 – Unprocessable Entity – Should be used if the server cannot process the enitity, e.g. if an image cannot be formatted or mandatory fields are missing in the payload.
     */

    /**
     * Metodo para devolver resposta de sucesso.
     *
     * @param  $dados, os dados que serão retornados para o cliente
     * @param  $mensagem, mensagem
     * @param  $codigo, código http a ser retornado
     * @return \Illuminate\Http\Response
     */
    public function enviarRespostaSucesso($dados, $mensagem = 'Sucesso', $codigo = 200)
    {
        $resposta = [
            'dados'    => $dados,
            'mensagem' => $mensagem,
        ];

        return response()->json($resposta, $codigo);
    }

    /**
     * Metodo para devolver resposta de erro.
     *
     * @param $erroPrincipal, mensagem de erro principal
     * @param $errosSecundarios, pode ser um vetor com mais mensagens de erro, ou apenas uma explicação melhor do erro principal
     * @param $codigo, código do erro, por padrão é 400
     * @return \Illuminate\Http\Response
     */
    public function enviarRespostaErro($erroPrincipal, $errosSecundarios = [], $codigo = 400)
    {
        $resposta = [
            'mensagem'         => $erroPrincipal,
            'errosSecundarios' => $errosSecundarios
        ];

        return response()->json($resposta, $codigo);
    }
}
