<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ConsultaController extends Controller
{
  public function consulta(Request $request) {
    try {
      $dado = $request->query('dado');

      // Regex
        $cpfCNPJ = '/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/';
        $CNS = '/^\d{15}$/';
        $noNumber = '/^([^0-9]*)$/';

        $numeros; // Declaração da variável fora do escopo do if CPF/CNPJ.

      if (preg_match($noNumber, $dado) AND trim($dado)) {
        return 'Nome: '.$dado;

      } elseif (preg_match($CNS, $dado)) {
        return 'CNS: '.$dado;

      } elseif(preg_match($cpfCNPJ, $dado)) {
        $numeros = preg_replace('/[^0-9]/', '', $dado); // Dado sem caracteres especiais

        if (strlen($numeros) == 11) {
          return 'CPF: '.$numeros;

        } elseif (strlen($numeros) == 14) {
          return 'CNPJ: '.$numeros;
        }

      }
      
      return 'Dado inválido: '.$dado;

    } catch (Throwable $th) {
      dd($th);
      return 'error';
    }
  }
}
