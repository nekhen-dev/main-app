<?php

namespace App\Http\Controllers\Consumidor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\ModelCadastroUC;
use App\User;

class AddUcController extends Controller
{

    public $dados;
    
    public function index(Request $request){
        $this->dados = $this->validacao($request->input());
        DB::beginTransaction();
        $hash_uc = hash('md2','oros'.\Auth::user()->email.time());
        try{
            \Auth::user()->ucs()->create([
                'hash' => $hash_uc,
                "tipo_estabelecimento" => $this->dados["tipo_estabelecimento"],
                "endereco" => $this->dados["endereco"],
                "num_endereco" => $this->dados["num_endereco"],
                "cep" => $this->dados["cep"],
                "uf" => $this->dados["uf"],
                "municipio" => $this->dados["cidade"],
                "concessionaria" => $this->dados["concessionaria"],
                "grupo" => $this->dados["grupo"],
                "classe" => $this->dados["classe"],
                "modalidade" => $this->dados["modalidade"],
                "consumo_conv" => ($this->dados["consumo_conv"]),
                "consumo_conv_total" => ($this->dados["consumo_conv_total"]),
                "consumo_fp" => ($this->dados["consumo_fp"]),
                "consumo_fp_total" => ($this->dados["consumo_fp_total"]),
                "consumo_int" => ($this->dados["consumo_int"]),
                "consumo_int_total" => ($this->dados["consumo_int_total"]),
                "consumo_p" => ($this->dados["consumo_p"]),
                "consumo_p_total" => ($this->dados["consumo_p_total"]),
                "consumo_total" => ($this->dados["consumo_conv_total"]+$this->dados["consumo_fp_total"]+$this->dados["consumo_int_total"]+$this->dados["consumo_p_total"])
            ]);
            DB::commit();
            return redirect()->route('MinhasUCs')
                    ->with("msg.status",200)
                    ->with("msg.texto",'Unidade consumidora cadastrada com sucesso.')
                    ->with("msg.hash_uc",$hash_uc);


        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->route('CadastrarUC')
                ->with("msg.status",$ex->getCode())
                ->with("msg.texto",'Não foi possível cadastrar a unidade consumidora. Tente mais tarde.');
        }
    }
    
    private function validacao($dados){
        $tipo_estabelecimento = filter_var($dados['tipo_uc'],FILTER_SANITIZE_NUMBER_INT);
        $endereco = htmlspecialchars($dados['endereco_uc'],ENT_QUOTES);
        $num_endereco = htmlspecialchars($dados['num_endereco_uc'],ENT_QUOTES);
        $comp_endereco = htmlspecialchars($dados['comp_endereco_uc'],ENT_QUOTES);
        $cep = str_replace("-","",htmlspecialchars($dados['cep_uc'],ENT_QUOTES));
        $uf = htmlspecialchars($dados['uf_uc'],ENT_QUOTES);
        $cidade = filter_var($dados['sel_cidade_endereco_uc'], FILTER_SANITIZE_NUMBER_INT);
        $concessionaria = filter_var($dados['concessionaria_uc'], FILTER_SANITIZE_NUMBER_INT);
        
        $check_consumo_conv = (isset($dados['check_conv']))?true:false;
        $check_consumo_fp_p = (isset($dados['check_fp_p']))?true:false;
        $check_consumo_int = (isset($dados['check_int']))?true:false;

        $grupo = 'null';
        $classe = 'null';
        $modalidade = 'null';
        if($check_consumo_conv || ($check_consumo_fp_p && $check_consumo_int)){
            $grupo = 'B';
            $classe = 'B'.$tipo_estabelecimento;
            if($check_consumo_fp_p && $check_consumo_int){
                $modalidade = 'branca';
            }else{
                $modalidade = 'conv';
            }
        }else{
            if(!$check_consumo_conv && $check_consumo_fp_p && !$check_consumo_int){
                $grupo = 'A';
                $classe = 'NA';//Grupo A não tem classe
                $modalidade = 'TBD';//Modalidade do Grupo A será definida em outro passo
            }
        }
        
        $check_media_consumo = (isset($dados['check_media_consumo']))?true:false; //Captura se marcou a média
        $check_consumo_historico = (isset($dados['check_historico']))?true:false; //Captura se marcou a média
        
        $media_ou_historico = '';
        if($check_media_consumo){
            $media_ou_historico = 'media';
        }else{
            if($check_consumo_historico){
                $media_ou_historico = 'historico';
            }else{
                //Erro ou bug
                //TODO: Incluir resposta neste caso
            }
        }
        $lista_meses = [];
        if($media_ou_historico == 'historico'){
            for($mes=1;$mes<=12;$mes++){
                (isset($dados['check_mes_consumo_'.$this->get_nome_mes($mes)]))?array_push($lista_meses,$mes):false;
            }
        }
        
        
        /*****************************
        Faz a validação dos dados
        /************************ */
        //Valida as informações gerais
        if($tipo_estabelecimento == '' || !is_numeric($tipo_estabelecimento)){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Defina o tipo de estabelecimento.');
        } 
        if($endereco == ''){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'O endereço é obrigatório.');
        }
        if($num_endereco == ''){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'O número do endereço é obrigatório.');
        }
        if(strlen((string)$cep) != 8 || !is_numeric($cep)){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Preencha um CEP válido.');
        }
        $cep = substr($cep,0,5).'-'.substr($cep,5,7);
        if( $uf == '' || strlen((string)$uf) != 2 || is_numeric($uf)){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Escolha a sua UF.');
        }
        if($cidade == '' || !is_numeric($cidade)){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Escolha a cidade.');
        }
        if($concessionaria == '' || !is_numeric($concessionaria)){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Escolha a concessionária.');
        }
        
        //Valida os tipos de consumo
        if(!$check_consumo_conv && !$check_consumo_fp_p && !$check_consumo_int){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Escolha pelo menos 1 tipo de consumo.');
        }
        if($check_consumo_int && !$check_consumo_fp_p){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Se há consumo na faixa Intermediária, então também há consumo nas faixas Fora da Ponta e na Ponta.');
        }
        if($check_consumo_conv && ($check_consumo_fp_p  || $check_consumo_int)){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Se há consumo convensional, então não há consumo nas faixas Fora da Ponta e na Ponta.');
        }
        if($check_consumo_fp_p && $check_consumo_conv){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Se há consumo convensional, então não há consumo nas faixas Fora da Ponta e na Ponta.');
        }
        
        //Só pode fornecer a média ou o histórico
        if($check_media_consumo && $check_consumo_historico){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Escolha preencher apenas o último consumo ou histório.');
        }
        
        
        $soma_consumo = 0;//Reseta a soma do consumo
        if($grupo == 'A'){
            if($media_ou_historico == 'media'){
                ($dados['consumo_media_fp'] == '')?$dados['consumo_media_fp']=0:false;
                ($dados['consumo_media_p'] == '')?$dados['consumo_media_p']=0:false;
                if(!$this->valida_numero_real($dados['consumo_media_fp'])){
                    return redirect()->route('CadastrarUC')
                    ->with("msg.status",500)
                    ->with("msg.texto",'Consumo precisa ser um número.');
                }
                if(!$this->valida_numero_real($dados['consumo_media_p'])){
                    return redirect()->route('CadastrarUC')
                    ->with("msg.status",500)
                    ->with("msg.texto",'Consumo precisa ser um número.');
                }
        
                $soma_consumo += $dados['consumo_media_fp'];
                $soma_consumo += $dados['consumo_media_p'];
            }else{
                foreach($lista_meses as $mes){
                    ($dados['consumo_fp_'.$this->get_nome_mes($mes)] == '')?$dados['consumo_fp_'.$this->get_nome_mes($mes)]=0:false;
                    ($dados['consumo_p_'.$this->get_nome_mes($mes)] == '')?$dados['consumo_p_'.$this->get_nome_mes($mes)]=0:false;
                    if(!$this->valida_numero_real($dados['consumo_fp_'.$this->get_nome_mes($mes)])){
                        return redirect()->route('CadastrarUC')
                        ->with("msg.status",500)
                        ->with("msg.texto",'Consumo precisa ser um número.');
                    }
                    if(!$this->valida_numero_real($dados['consumo_p_'.$this->get_nome_mes($mes)])){
                        return redirect()->route('CadastrarUC')
                        ->with("msg.status",500)
                        ->with("msg.texto",'Consumo precisa ser um número.');
                    }
                    
                    $soma_consumo += $dados['consumo_fp_'.$this->get_nome_mes($mes)];
                    $soma_consumo += $dados['consumo_p_'.$this->get_nome_mes($mes)];
                }
            }
        }else{
            if($modalidade == 'conv'){
                if($media_ou_historico == 'media'){
                    ($dados['consumo_media_conv'] == '')?$dados['consumo_media_conv']=0:false;
                    if(!$this->valida_numero_real($dados['consumo_media_conv'])){
                        return redirect()->route('CadastrarUC')
                        ->with("msg.status",500)
                        ->with("msg.texto",'Consumo precisa ser um número.');
                    }
        
                    $soma_consumo += $dados['consumo_media_conv'];
                }else{
                    foreach($lista_meses as $mes){
                        ($dados['consumo_conv_'.$this->get_nome_mes($mes)] == '')?$dados['consumo_conv_'.$this->get_nome_mes($mes)]=0:false;
                        if(!$this->valida_numero_real($dados['consumo_conv_'.$this->get_nome_mes($mes)])){
                            return redirect()->route('CadastrarUC')
                            ->with("msg.status",500)
                            ->with("msg.texto",'Consumo precisa ser um número.');
                        }        
                        $soma_consumo += $dados['consumo_conv_'.$this->get_nome_mes($mes)];
                    }
                }
            }else{
                if($media_ou_historico == 'media'){
                    ($dados['consumo_media_fp'] == '')?$dados['consumo_media_fp']=0:false;
                    ($dados['consumo_media_p'] == '')?$dados['consumo_media_p']=0:false;
                    ($dados['consumo_media_int'] == '')?$dados['consumo_media_int']=0:false;
                    if(!$this->valida_numero_real($dados['consumo_media_fp'])){
                        return redirect()->route('CadastrarUC')
                        ->with("msg.status",500)
                        ->with("msg.texto",'Consumo precisa ser um número.');
                    }  
                    if(!$this->valida_numero_real($dados['consumo_media_p'])){
                        return redirect()->route('CadastrarUC')
                        ->with("msg.status",500)
                        ->with("msg.texto",'Consumo precisa ser um número.');
                    }  
                    if(!$this->valida_numero_real($dados['consumo_media_int'])){
                        return redirect()->route('CadastrarUC')
                        ->with("msg.status",500)
                        ->with("msg.texto",'Consumo precisa ser um número.');
                    }          
                    $soma_consumo += $dados['consumo_media_fp'];
                    $soma_consumo += $dados['consumo_media_p'];
                    $soma_consumo += $dados['consumo_media_int'];
        
                }else{
                    foreach($lista_meses as $mes){
                        ($dados['consumo_fp_'.$this->get_nome_mes($mes)] == '')?$dados['consumo_fp_'.$this->get_nome_mes($mes)]=0:false;
                        ($dados['consumo_p_'.$this->get_nome_mes($mes)] == '')?$dados['consumo_p_'.$this->get_nome_mes($mes)]=0:false;
                        ($dados['consumo_int_'.$this->get_nome_mes($mes)] == '')?$dados['consumo_int_'.$this->get_nome_mes($mes)]=0:false;
                        if(!$this->valida_numero_real($dados['consumo_fp_'.$this->get_nome_mes($mes)])){
                            return redirect()->route('CadastrarUC')
                            ->with("msg.status",500)
                            ->with("msg.texto",'Consumo precisa ser um número.');
                        }  
                        if(!$this->valida_numero_real($dados['consumo_p_'.$this->get_nome_mes($mes)])){
                            return redirect()->route('CadastrarUC')
                            ->with("msg.status",500)
                            ->with("msg.texto",'Consumo precisa ser um número.');
                        }  
                        if(!$this->valida_numero_real($dados['consumo_int_'.$this->get_nome_mes($mes)])){
                            return redirect()->route('CadastrarUC')
                            ->with("msg.status",500)
                            ->with("msg.texto",'Consumo precisa ser um número.');
                        }   
        
                        $soma_consumo += $dados['consumo_fp_'.$this->get_nome_mes($mes)];
                        $soma_consumo += $dados['consumo_p_'.$this->get_nome_mes($mes)];
                        $soma_consumo += $dados['consumo_int_'.$this->get_nome_mes($mes)];
                    }
                }
            }
        }
        
        //Consumo total tem que ser maior que zero
        if($soma_consumo <= 0){
            return redirect()->route('CadastrarUC')
            ->with("msg.status",500)
            ->with("msg.texto",'Consumo precisa ser maior que zero.');
        }
        
        
        /*
        Se chegou aqui então tudo foi validado!!
        Agora basta criar os vetores e o json
        */
        $tab_consumo = $this->agrupa_mes_consumo($grupo,$modalidade,$media_ou_historico,$dados); //Gera a tabela de consumo
        
        $tab_consumo_conv = "";
        $consumo_conv_total = 0;
        
        $tab_consumo_fp = "";
        $consumo_fp_total = 0;
        
        $tab_consumo_int = "";
        $consumo_int_total = 0;
        
        $tab_consumo_p = "";
        $consumo_p_total = 0;

        for($mes=0;$mes<12;$mes++){
            $tab_consumo_conv .= $tab_consumo[$mes]["conv"];
            $consumo_conv_total += $tab_consumo[$mes]["conv"];
            
            $tab_consumo_fp .= $tab_consumo[$mes]["fp"];
            $consumo_fp_total += $tab_consumo[$mes]["fp"];

            $tab_consumo_int .= $tab_consumo[$mes]["int"];
            $consumo_int_total += $tab_consumo[$mes]["int"];

            $tab_consumo_p .= $tab_consumo[$mes]["p"];
            $consumo_p_total += $tab_consumo[$mes]["p"];

            if($mes<12-1){
                $tab_consumo_conv .= ",";
                $tab_consumo_fp .= ",";
                $tab_consumo_int .= ",";
                $tab_consumo_p .= ",";
            }
        }
        

        return array(
            "tipo_estabelecimento" => $tipo_estabelecimento,
            "endereco" => $endereco,
            "num_endereco" => $num_endereco,
            "cep" => $cep,
            "uf" => $uf,
            "cidade" => $cidade,
            "concessionaria" => $concessionaria,
            "grupo" => $grupo,
            "classe" => $classe,
            "modalidade" => $modalidade,
            "consumo_conv" => $tab_consumo_conv,
            "consumo_conv_total" => $consumo_conv_total,
            "consumo_fp" => $tab_consumo_fp,
            "consumo_fp_total" => $consumo_fp_total,
            "consumo_int" => $tab_consumo_int,
            "consumo_int_total" => $consumo_int_total,
            "consumo_p" => $tab_consumo_p,
            "consumo_p_total" => $consumo_p_total
        );
        
    }
    private function valida_numero_real($valor){
        if(!isset($valor)){
            return false;
        }else{
            $valor_ = htmlspecialchars($valor,ENT_QUOTES);
            // if($valor_ == '' || !is_numeric(str_replace(",",".",$valor_))){
            if(!is_numeric(str_replace(",",".",$valor_))){
                return false;
            }
        }
        return true;
    }
    private function gera_array_consumo($mes,$grupo,$modalidade,$dados){
        $conv = 0.0;
        $fp = 0.0;
        $int = 0.0;
        $p = 0.0;
        if(isset($dados['check_mes_consumo_'.$mes])){
            if($grupo == 'B'){
                if($modalidade == 'conv'){
                    $conv = (double)str_replace(",",".",htmlspecialchars($dados['consumo_conv_'.$mes],ENT_QUOTES));
                }else{
                    if($modalidade == 'branca'){
                        $fp = (double)str_replace(",",".",htmlspecialchars($dados['consumo_fp_'.$mes],ENT_QUOTES));
                        $int = (double)str_replace(",",".",htmlspecialchars($dados['consumo_int_'.$mes],ENT_QUOTES));
                        $p = (double)str_replace(",",".",htmlspecialchars($dados['consumo_p_'.$mes],ENT_QUOTES));
                    }
                }
            }else{
                if($grupo == 'A'){
                    $fp = (double)str_replace(",",".",htmlspecialchars($dados['consumo_fp_'.$mes],ENT_QUOTES));
                    $p = (double)str_replace(",",".",htmlspecialchars($dados['consumo_p_'.$mes],ENT_QUOTES));
                }
            }
        }
        return array('conv' => $conv,'fp' => $fp,'int' => $int,'p' => $p);
    }
    private function gera_array_consumo_media($grupo,$modalidade,$dados){
        $conv = 0.0;
        $fp = 0.0;
        $int = 0.0;
        $p = 0.0;
        if($grupo == 'B'){
            if($modalidade == 'conv'){
                $conv = (double)str_replace(",",".",htmlspecialchars($dados['consumo_media_conv'],ENT_QUOTES));
            }
            if($modalidade == 'branca'){
                $fp = (double)str_replace(",",".",htmlspecialchars($dados['consumo_media_fp'],ENT_QUOTES));
                $int = (double)str_replace(",",".",htmlspecialchars($dados['consumo_media_int'],ENT_QUOTES));
                $p = (double)str_replace(",",".",htmlspecialchars($dados['consumo_media_p'],ENT_QUOTES));
            }
        }else{
            $fp = (double)str_replace(",",".",htmlspecialchars($dados['consumo_media_fp'],ENT_QUOTES));
            $p = (double)str_replace(",",".",htmlspecialchars($dados['consumo_media_p'],ENT_QUOTES));
        }
        
        return array('conv' => $conv,'fp' => $fp,'int' => $int,'p' => $p);
    }
    private function get_nome_mes($mes_num){
        switch($mes_num){
            case 1: return 'jan';break;
            case 2: return 'fev';break;
            case 3: return 'mar';break;
            case 4: return 'abr';break;
            case 5: return 'mai';break;
            case 6: return 'jun';break;
            case 7: return 'jul';break;
            case 8: return 'ago';break;
            case 9: return 'set';break;
            case 10: return 'out';break;
            case 11: return 'nov';break;
            case 12: return 'dez';break;
        }
    }
    private function gera_consumo_vazio($tab_consumo,$grupo,$modalidade){
        $novo_tab_consumo = $tab_consumo;
        $soma = array('conv'=> 0.0,'fp'=> 0.0,'int'=> 0.0,'p'=> 0.0);
        $cont = array('conv'=> 0,'fp'=> 0,'int'=> 0,'p'=> 0);
        for($i=0;$i<12;$i++){
            if($grupo == 'B'){
                if($modalidade == 'conv'){
                    if($novo_tab_consumo[$i]['conv']>0){
                        $soma['conv'] += $novo_tab_consumo[$i]['conv'];
                        $cont['conv'] += 1;
                    }
                }
                if($modalidade == 'branca'){
                    if($novo_tab_consumo[$i]['fp']>0){
                        $soma['fp'] += $novo_tab_consumo[$i]['fp'];
                        $cont['fp'] += 1;
                    }
                    if($novo_tab_consumo[$i]['int']>0){
                        $soma['int'] += $novo_tab_consumo[$i]['int'];
                        $cont['int'] += 1;
                    }
                    if($novo_tab_consumo[$i]['p']>0){
                        $soma['p'] += $novo_tab_consumo[$i]['p'];
                        $cont['p'] += 1;
                    }
                }
            }else{
                if($novo_tab_consumo[$i]['fp']>0){
                    $soma['fp'] += $novo_tab_consumo[$i]['fp'];
                    $cont['fp'] += 1;
                }
                if($novo_tab_consumo[$i]['p']>0){
                    $soma['p'] += $novo_tab_consumo[$i]['p'];
                    $cont['p'] += 1;
                }
            }
        }
        for($i=0;$i<12;$i++){
            if($grupo == 'B'){
                if($modalidade == 'conv'){
                    if($novo_tab_consumo[$i]['conv'] == 0 && $cont['conv']>0){
                        $novo_tab_consumo[$i]['conv'] = $soma['conv']/$cont['conv'];
                    }
                }
                if($modalidade == 'branca'){
                    if($novo_tab_consumo[$i]['fp'] == 0 && $cont['fp']>0){
                        $novo_tab_consumo[$i]['fp'] = $soma['fp']/$cont['fp'];
                    }
                    if($novo_tab_consumo[$i]['int'] == 0 && $cont['int']>0){
                        $novo_tab_consumo[$i]['int'] = $soma['int']/$cont['int'];
                    }
                    if($novo_tab_consumo[$i]['p'] == 0 && $cont['p']>0){
                        $novo_tab_consumo[$i]['p'] = $soma['p']/$cont['p'];
                    }
                }
            }
            else{
                if($novo_tab_consumo[$i]['fp'] == 0 && $cont['fp']>0){
                    $novo_tab_consumo[$i]['fp'] = $soma['fp']/$cont['fp'];
                }
                if($novo_tab_consumo[$i]['p'] == 0 && $cont['p']>0){
                    $novo_tab_consumo[$i]['p'] = $soma['p']/$cont['p'];
                }
            }
        }
        return $novo_tab_consumo;
    }
    private function agrupa_mes_consumo($grupo,$modalidade,$media_ou_historico,$dados){
        $arr_consumo = array();
        for($i=1;$i<=12;$i++){
            switch($media_ou_historico){
                case 'media': $arr_consumo[] = $this->gera_array_consumo_media($grupo,$modalidade,$dados); break;
                case 'historico': $arr_consumo[] = $this->gera_array_consumo($this->get_nome_mes($i),$grupo,$modalidade,$dados); break;
            }
        }
        switch($media_ou_historico){
            case 'media': return $arr_consumo;break;
            case 'historico': return $this->gera_consumo_vazio($arr_consumo,$grupo,$modalidade);break;
        }
    }
}
