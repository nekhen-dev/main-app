//<script src="/plataforma/secao/scripts_form.js"></script>
var imported = document.createElement('script');
imported.src = '/plataforma/secao/scripts_form.js';
document.head.appendChild(imported);

function url_viacep(cep){
    return "https://viacep.com.br/ws/"+cep+"/json/";
}
function avalia_retorno_viacep(data){
    if(data.erro===true){
        return false;
    }else{
        var obj = {
                'endereco':data.logradouro,
                'cidade':data.localidade,
                'uf':data.uf
                };
        return obj;
    }
}

function url_postmon(cep){
    return "https://api.postmon.com.br/v1/cep/"+cep;
}
function avalia_retorno_postmon(data){
    var obj = {
            'endereco':data.logradouro,
            'cidade':data.cidade,
            'uf':data.estado
            };
    return obj;
}
//busca_cep(cep,'viacep',inputs,'#procurando_cep','#msg_cep','#desbloquear_form','#distribuidora_uc');
function busca_cep(cep,provedor,id_saida,id_buscando,id_erro,desbloquear_form,id_concessionarias){
    $(id_buscando).html("<br/>Procurando CEP...");
    $(id_erro).html('');
    
    cep = cep.replace("-","");
    cep = cep.replace(".","");
    var url = '';
    switch(provedor){
        //case 'postmon': url = url_postmon(cep); break;
        case 'viacep': url = url_viacep(cep); break;
        default: provedor ='viacep' ;url = url_viacep(cep); break;
    }

    if(provedor=='viacep'){
        $.get( url )
            .done(function( data_retorno ) {
                if(data_retorno['erro']===true){
                    $(id_erro).html('<br/>CEP não encontrado');
                    $(desbloquear_form).html('Inserir manualmente')
                }else{
                    resultado = avalia_retorno_viacep(data_retorno);
                    if(resultado.endereco==="" || resultado.cidade==="" || resultado.uf===""){
                        
                        
                        $(id_saida.endereco).val('');
                        
                        $(id_saida.cidade_input).hide();
                        $(id_saida.cidade_input).val('');
                        
                        $(id_saida.uf).val('0');
                        
                        $(id_saida.cidade_select).val('0');
                        $(id_saida.cidade_select).show();
                        
                        abrir_form(id_saida,'input_bloqueado');
                        
                        $(id_erro).html('<br/>Não achamos seu endereço completo, preencha manualmente.');
                        
                        $(desbloquear_form).hide();
                        
                        $(id_concessionarias).val('0');
                        abrir_form({'concessionarias':id_concessionarias},'input_bloqueado');
                        
                    }else{
                        $(desbloquear_form).show();
                         
                        $(id_saida.endereco).val(resultado.endereco);
                        
                        $(id_saida.cidade_input).show();
                        $(id_saida.cidade_input).val(resultado.cidade);
                        
                        $(id_saida.uf).val(resultado.uf);
                        $(desbloquear_form).html('Não é meu endereço');
                        
                        $(id_saida.cidade_select).val('0');
                        $(id_saida.cidade_select).hide();
                        
                        abrir_form({'concessionarias':id_concessionarias},'input_bloqueado');
                        if(resultado.uf!==""){
                            //listar_concessionarias(resultado.uf,id_concessionarias)
                            get_list_form('concessionarias','uf='+resultado.uf,id_concessionarias);
                            
                        }else{
                            $(id_concessionarias).val('0');
                        }
                    }
                }
                
            })
            .fail(function(){
                $(id_erro).html('<br/>CEP não encontrado, preencha manualmente.');
                //$(desbloquear_form).html('Inserir manualmente');
                //$(desbloquear_form).show();
                abrir_form(id_saida,'input_bloqueado');
                
                $(id_saida.cidade_input).val('0');
                $(id_saida.cidade_input).hide();
                
                $(id_saida.cidade_select).val('0');
                $(id_saida.cidade_select).show();
                
                abrir_form({'concessionarias':id_concessionarias},'input_bloqueado');
                $(id_concessionarias).val('0');
                
            });
    }
    $(id_buscando).html("");
}

