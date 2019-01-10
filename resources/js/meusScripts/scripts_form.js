function limpa_form(inputs){
    for (var key in inputs) {
        if (inputs.hasOwnProperty(key)) {
            $(inputs[key]).val('');
        }
    }
}
function abrir_form(inputs,class_input_bloqueado){
    for (var key in inputs) {
        if (inputs.hasOwnProperty(key)) {
            $(inputs[key]).removeClass(class_input_bloqueado);
            $(inputs[key]).prop("disabled", false);
        }
    }
}
function bloquear_form(inputs,class_input_bloqueado){
    for (var key in inputs) {
        if (inputs.hasOwnProperty(key)) {
            $(inputs[key]).addClass(class_input_bloqueado);
            $(inputs[key]).prop("disabled", true);
        }
    }
}
function get_list_form_from_json(json,select_form_input){
    $(select_form_input).children('option:not(:first)').remove();
    $(select_form_input).val('0');
    
    for(var i=0;i<json.length;i++){
        $(select_form_input).append("<option value='"+json[i].valor+"'>"+json[i].nome+"</option>");
    }
    $(select_form_input).prop('disabled',false);
}

function get_list_form(tipo_dados,url,select_form_input){
    $(select_form_input).prop('disabled',true);
    $(select_form_input).append("<option value='-1'>Carregando...</option>");
    $(select_form_input).val('-1');
    
    // var url='';
    // switch(objetivo){
    //     case 'municipios': url = '/plataforma/api/get_municipios/v0/?'+tag;break;
    //     case 'concessionarias': url = '/plataforma/api/get_concessionarias/v0?'+tag;break;
    // }
    // console.log(url);
    $.get(url)
        .done(function(data){
            // console.log(data);
            var json = data;//jQuery.parseJSON(data);
            
            switch(tipo_dados){
                case 'concessionarias': var resultado = json.resposta.concessionarias; break;
                case 'municipios': var resultado = json.resposta.municipios; break;
            }

            
            $(select_form_input).children('option:not(:first)').remove();
            $(select_form_input).val('0');
            
            for(var i=0;i<resultado.length;i++){
                $(select_form_input).append("<option value='"+resultado[i].valor+"'>"+resultado[i].nome+"</option>");
            }
            $(select_form_input).prop('disabled',false);
           
        });    
}
function encontra_em_json(json,uf,tipo){
    for(var i=0;i<json.length;i++){
        if(json[i].uf == uf){
            switch(tipo){
                case 'concessionarias': return json[i].concessionarias;break;
                case 'municipios': return json[i].municipios;break;
            }
        }
    }
}
function get_nome_mes(mes_num,nome_completo){
    if(nome_completo){
        switch(mes_num){
            case 1: return 'Janeiro';break;
            case 2: return 'Fevereiro';break;
            case 3: return 'Março';break;
            case 4: return 'Abril';break;
            case 5: return 'Maio';break;
            case 6: return 'Junho';break;
            case 7: return 'Julho';break;
            case 8: return 'Agosto';break;
            case 9: return 'Setembro';break;
            case 10: return 'Outubro';break;
            case 11: return 'Novembro';break;
            case 12: return 'Dezembro';break;
        }
    }else{
        switch(mes_num){
            case 1: return 'Jan';break;
            case 2: return 'Fev';break;
            case 3: return 'Mar';break;
            case 4: return 'Abr';break;
            case 5: return 'Mai';break;
            case 6: return 'Jun';break;
            case 7: return 'Jul';break;
            case 8: return 'Ago';break;
            case 9: return 'Set';break;
            case 10: return 'Out';break;
            case 11: return 'Nov';break;
            case 12: return 'Dez';break;
        }
    }
}