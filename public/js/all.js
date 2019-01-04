class myLaws{
    /*
    This class lets yout create your laws.
    
    A new law must be added with the data structure below:


    let laws = new myLaws();
    laws.add_law(
        {
            name:'my new law',
            ref:[
                {name:'require_one | require_sum_not_zero | require_not_null | require_not_zero | require_zipcode | require_length_min | require_num | require_email |...'}
            ],
            msg:'This law must be fulfilled',
            style_outlaws:'my_style_class'
        }
    );
    
    */
    constructor(){
        this.list = [];
        this.get_laws = function(){
            //Returns the list of current laws
            return this.list;
        }
        this.reset_laws = function(){
            //Resets the current laws
            this.list = [];
        }
    }
    add_law(new_law){
        //Adds a new law in the terms above
        this.list.push(new_law);
    }
}
class myJudge{
    constructor(_container,_laws) {
        this.container = _container; //A HTML structure like div, form, table, etc..
        this.laws = _laws; //List of laws to be pressed

        /*  ******************************
        List of laws violated by the outlaws
        It will be return with the following data structure:

        this.accusations =[
            outLaws:[
                {
                    law: "myrule1",
                    lawMsg: "This law must be fulfilled",
                    ref:[
                        {
                            refName:"require_not_null",
                            obj:[
                                {ifObjNotValid: "field1", tagOutlaw:"tag1"},
                                {ifObjNotValid: "field2", tagOutlaw:"tag2"}
                            ]
                        },
                        {
                            refName:"require_not_zero",
                            obj:[
                                {ifObjNotValid: "field3", tagOutlaw:"tag1"}
                            ]
                        }
                    ]
                },
                {
                    law: "myrule2",
                    lawMsg: "This other law also must be fulfilled",
                    ref:[
                        {
                            refName:"require_zipcode",
                            obj:[
                                {ifObjNotValid: "field1", tagOutlaw:"tag1"},
                                {ifObjNotValid: "field2", tagOutlaw:"tag2"}
                            ]
                        }
                    ]
                }
            ]
        ]
        ************************************  */
        this.accusations = [];
        this.get_accusations = function(){
            return this.accusations;
        }
        this.set_accusations = function(_accusations){
            this.accusations = _accusations;
        }

        // ******************************
        //Returns true or false of there are outlaw fields
        this.hasOutlaws = false;
        this.set_hasOutlaws = function(_hasOutlaws){
            this.hasOutlaws = _hasOutlaws;
        }
        this.get_hasOutlaws = function(){
            return this.hasOutlaws;
        }
        
        /******************************
        Gets all laws violated by each outlaw
        It will return the following data structure
        this.tagged = [
            {law: "myrule1", refName: "require_not_null", tagOutlaw: "field1"},
            {law: "myrule2", refName: "require_not_zero", tagOutlaw: "field1"},
            {law: "myrule1", refName: "require_not_null", tagOutlaw: "field2"},
            {law: "myrule3", refName: "require_not_zero", tagOutlaw: "field4"}
        ]
        ********************************/
        this.tagged = [];
        this.get_tagged = function(){
            return this.tagged;
        }
        this.set_tagged = function(_tagged){
            this.tagged = _tagged;
        }

        /******************************
        Gets only one violated law per outlaw
        If the same outlaw violates different laws, he will be charged against the first added
        It will return the following data structure
        this.listOfTags = [
            {law: "myrule1", refName: "require_not_null", tagOutlaw: "field1"},
            {law: "myrule1", refName: "require_not_null", tagOutlaw: "field2"},
            {law: "myrule3", refName: "require_not_zero", tagOutlaw: "field4"}
        ]
        *******************************/
        this.listOfTags =[];
        this.get_listOfTags = function(){
            return this.listOfTags;
        }
        this.set_listOfTags = function(_listOfTags){
            this.listOfTags = _listOfTags;
        }
        this.list_tags = function(){
            /*********************************
            Lists one violated law per outlaw
            **********************************/

            //Support function
            function find_tags(item,arr){
                /*
                Searches inside the tags array for a given item
                Returns true if found
                Returns false if not
                */
                for(var i=0;i<arr.length;i++){
                    if(item == arr[i]){
                        return true;
                    }
                }
                return false;
            }
            /*
            Main code starts here
            */
            var tagged = this.get_tagged();
            var tags = [];
            var violatedLaws = [];
            var countTags =0;
            tagged.forEach(function(t){
                var item = t.tagOutlaw;
                var law = t.law;
                if(!find_tags(item,tags)){
                    violatedLaws.push(law);
                    tags.push(item);
                    countTags++;
                }
            });
            var pair = [];
            for (var i=0;i<countTags;i++){
                pair.push({'law':violatedLaws[i],'tag':tags[i]});
            }
            this.set_listOfTags(pair);
        }
    }
    work(){
        /*********************************
        The judge will evaluate the accusations against the outlaws
        **********************************/
       
        /*
        Support functions
        */
        function isNumeric(n){
        return !isNaN(parseFloat(n)) && isFinite(n);
        }
        function commaToDot(n){
            /*
            I use this function because of the Brazilian standard.
            We use a comma as decimals separator
            If you use other standard, you can change it here or add a new one
            This function is used again in functions 'analyzeIndiv' and 'analyzeGroup'
            */
            return parseFloat(n.replace(',','.'));
        }
        function findInArray(arr,prop,propValue){
            /*
            Searches an array for a property and compares its value to another
            Returns true if property value is found
            Returns false if not
            */
            for(var i=0;i<arr.length;i++){
                if(arr[i].hasOwnProperty(prop)){
                    if(arr[i][prop] == propValue){
                        return {found:true,index:i};
                    }
                }
            }
            return {found:false};
        }
        function get_typeOfRef(ref){
            switch(ref){
                //List law refs applied to groups of fields
                //[Add new ones here]
                case 'require_one_check': 
                case 'require_sum_ge':
                case 'require_sum_le':
                case 'require_sum_geq':
                case 'require_sum_leq':
                    return 'group';

                //List law refs applied to individuals 
                //[Add new ones here]
                case 'require_not_null': 
                case 'require_not_zero': 
                case 'require_zipcode': 
                case 'require_length_min':
                case 'require_num':
                case 'require_email':
                    return 'indiv';
            }
        }
        function analyzeIndiv(value,ref){
            /************************************
            Analyzes each individual field against the added laws
            You can add new ones following the already registered laws
            *************************************/
            
            if(ref.name == 'require_not_null'){
                return value != '';
            }
            if(ref.name == 'require_not_zero'){
                return value != 0;
            }
            
            if(value.length > 0){
                if(ref.name == 'require_num'){
                    return isNumeric(commaToDot(value));
                }
                if(ref.name == 'require_length_min'){
                    //If you want to use this law, don't forget to add a 'val' property,along side with the 'name' property.
                    //For instance, the val property is used here to evaluate the length of the input field value.
                    return value.length >= ref.val;
                }
                if(ref.name == 'require_zipcode'){
                    var zipcodeFormat = /^\d{5}-\d{3}$/; //Brazilian format, you can change to yours
                    return value.length == 9 && zipcodeFormat.exec(value) != null && isNumeric(value.replace('-',''));
                }
                if(ref.name == 'require_email'){
                    var emailFormat = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    return emailFormat.exec(value);
                }
            }else{
                return true;
            }
        }
        function analyzeGroup(obj,ref){
            /************************************
            Analyzes groups of field against the added laws
            You can add new ones following the already registered laws
            *************************************/
            if(ref.name == 'require_one_check'){
                var obj=obj[0];
                //Analyzes if at least on checkbox is checked
                if(obj.checked){
                    return true;
                }else{
                    return false;
                }
            }
            
            if(ref.name =='require_sum_ge'){
                //Analyzes if the sum of all input fields is greater than a value
                return commaToDot(obj.val()) > ref.val;
            }
            if(ref.name =='require_sum_le'){
                //Analyzes if the sum of all input fields is greater than a value
                return commaToDot(obj.val()) < ref.val;
            }
            if(ref.name =='require_sum_geq'){
                //Analyzes if the sum of all input fields is greater than a value or equals to
                return commaToDot(obj.val()) >= ref.val;
            }
            if(ref.name =='require_sum_leq'){
                //Analyzes if the sum of all input fields is less than a value or equals to
                return commaToDot(obj.val()) <= ref.val;
            }
            
            return true;
            
        }
        /***********************************
        Form validation starts here:
        For each law and ref finds outlaw fields inside a given container
        **************************************/
        var container = this.container;
        var laws = this.laws;
        var outLaws = [];
        var tagged = [];
        laws.forEach(function(r){
            var law = r.name;
            var lawMsg = r.msg;
            var refList = r.ref;
            refList.forEach(function(el){
                var ref = el;
                var refName = ref.name;
                var refType = get_typeOfRef(refName);
                if(refType == 'group'){
                    var groupTest = false;
                }
                var cont_ref = 0;
                container.find('.'+refName).each(function(){
                    cont_ref++;
                    var obj = $(this);
                    var val = $(this).val();
                    var idObjNotValid = $(this).attr('id');
                    var tagOutlaw = $(this).attr('tagOutlaw');
                    if(refType == 'indiv'){
                        if(!analyzeIndiv(val,el)){
                            tagged.push({law,refName,tagOutlaw});
                            var findLaw = findInArray(outLaws,'law',law);
                            if(findLaw.found){
                                var findRef = findInArray(outLaws[findLaw.index].ref,'refName',refName);
                                if(findRef.found){
                                    //Add object not valid
                                    var arrObj = outLaws[findLaw.index].ref[findRef.index].obj;
                                    arrObj.push({idObjNotValid,tagOutlaw});
                                }else{
                                    //Add refName-obj not valid
                                    var arrRef =  outLaws[findLaw.index].ref;
                                    arrRef.push({refName,'obj': [{idObjNotValid,tagOutlaw}]});
                                }
                            }else{
                                //Add law-refName-obj not valid
                                outLaws.push({law,lawMsg,'ref':[{refName,'obj': [{idObjNotValid,tagOutlaw}]}]});
                            }
                        }
                    }
                    if(refType == 'group'){
                        analyzeGroup(obj,ref)?groupTest = true:false;
                    }
                });
                if(refType == 'group' && cont_ref>0){
                    if(!groupTest){
                        var tagOutlaw = el.tagOutlaw;
                        outLaws.push({law,lawMsg,refName,tagOutlaw});
                        tagged.push({law,refName,tagOutlaw});
                    }
                }
            });
        });
        if(outLaws.length>0){
            this.set_accusations([{'outLaws':outLaws}])
            this.set_tagged(tagged);
            this.set_hasOutlaws(true);
            this.list_tags();
        }
    }
    arrest_outlaws(){
        /**************************
        This function adds the outLawStyle to all tagged elements
        ************************* */
        var container = this.container;
        var laws = this.laws;
        var tagList = this.get_listOfTags();
        tagList.forEach(function(t){
            var violatedLaws = t.law;
            var tag = t.tag;
            laws.forEach(function(l){
                var outLawsStyle = l.style_outlaws;
                var law = l.name;
                if(law == violatedLaws){
                    container.find('.'+tag).each(function(){
                        $(this).addClass(outLawsStyle);
                    });
                }
            });
        });
    }
    release_outlaws(){
        /**************************
        This function removes the outLawStyle to all tagged elements
        ************************* */
        var container = this.container;
        var laws = this.laws;
        laws.forEach(function(l){
            var outLawsStyle = l.style_outlaws;
            container.find('.'+outLawsStyle).each(function(){
                $(this).removeClass(outLawsStyle);
            });
        });
    }
}

    
// function limpar_validacoes(corpo,regras_obj){
//     var regras = regras_obj.validacao;
//     for(var i=0;i<regras.length;i++){
//         for(var j=0;j<regras[i].tipos.length;j++){
//             var nome_tipo = regras[i].tipos[j].nome;
//             corpo.find('.'+nome_tipo).each(function(){
//                 $(this).parent().find('label').removeClass('erro_validacao');
//             });
//         }
//     }
// }
function ir_para_msg_validacao(container){
    $(container).show();
    var altura_scroll = 0;//$('#'+ctn_msg_validacao).offset().top- $('#'+ctn_msg_validacao).height();
    $("html, body").animate({ scrollTop: altura_scroll}, "slow");
}


/*
Restringir o preenchimento

/^-?\d*$/ restricts input to integer numbers
/^\d*$/ restricts input to unsigned integer numbers
/^[0-9a-f]*$/i restricts input to hexadecimal numbers
/^-?\d*\.?\d*$/ restricts input to floating point numbers
/^-?\d*\.?\d{0,2}$/ restricts input to currency values (i.e. at most two decimal places)

*/
// Restricts input for all elements in the given jQuery object according to the given inputFilter.
function setInputFilter(obj, inputFilter) {
    obj.on("input keydown keyup mousedown mouseup select contextmenu", function() {
      filterInput(this);
    });
    obj.each(function(index, element) {
      element.inputFilter = inputFilter;
      filterInput(element);
    });
  }
  
  // Implements input filtering for the given textbox.
  function filterInput(textbox) {
    if (!textbox.hasOwnProperty("oldValue") || textbox.inputFilter(textbox.value)) {
      textbox.oldValue = textbox.value;
      textbox.oldSelectionStart = textbox.selectionStart;
      textbox.oldSelectionEnd = textbox.selectionEnd;
    } else {
      textbox.value = textbox.oldValue;
      textbox.setSelectionRange(textbox.oldSelectionStart, textbox.oldSelectionEnd);
    }
  }
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
class UnidadeConsumidora{
    constructor(_input){
        this.input = _input;
        this.dados = {};
        this.municipios = {};
        this.concessionarias = {};

        this.getDados = function(){
            return this.dados;
        }

        this.procurarNome = function(arr,index){
            for(var i=0;i<arr.length;i++){
                if(arr[i].valor == index){
                    return arr[i].nome;
                }
            }
        }
        this.tranfTipoUC = function(tipoUC){
            switch(tipoUC){
                case "1": return "Residencial";
                case "2": return "Rural";
                case "3": return "Comercial ou Industrial";
                case "4": return "Iluminação pública";

                default: return "Informação pendente";
            }
        }
        this.setConfiguracao = function(tipo_uc,tipos_consumo){
            /*
            tipo_uc = 1/2/3/4
            tipos_consumo = {
                conv: true/false,
                fp_p: true/false,
                int: true/false,
            }
            */

            if(tipos_consumo.conv){
                return {
                    grupo: "B"
                    ,classe: "B"+tipo_uc
                    ,modalidade: {
                        valor: "conv",
                        nome: "Convencional"
                    }
                };
            }
            if(tipos_consumo.int){
                return {
                    grupo: "B"
                    ,classe: "B"+tipo_uc
                    ,modalidade: {
                        valor: "branca",
                        nome: "Branca"
                    }
                };
            }
            if(tipos_consumo.fp_p){
                return {
                    grupo: "A"
                    ,classe: "N/A"
                    ,modalidade: {
                        // valor: "azul | verde",
                        // nome: "Azul | Verde"
                    }
                };
            }
        }
        this.consumoToFloat = function(consumo,media_ou_historico){
            if(media_ou_historico == "media"){
                for(var i in consumo){
                    consumo[i] = (consumo[i] == "")? 0:parseFloat(consumo[i]);
                }
            }
            if(media_ou_historico == "historico"){
                consumo.forEach(function(mes){
                    for(var i in mes.consumo){
                        mes.consumo[i] = (mes.consumo[i] == "")? 0:parseFloat(mes.consumo[i]);
                    }
                });
            }
            return consumo;
        }
        this.setConsumoAnual = function(media_ou_historico,consumo,configuracao){
            function setConsumoMedia(consumo,configuracao){
                var arrConsumoMedia = {};
                var arrConsumo = [];
                if(configuracao.grupo == "B"){
                    if(configuracao.modalidade.valor == "conv"){
                        arrConsumoMedia.conv = consumo.conv;
                    }
                    if(configuracao.modalidade.valor == "branca"){
                        arrConsumoMedia.fp = consumo.fp;
                        arrConsumoMedia.int = consumo.int;
                        arrConsumoMedia.p = consumo.p;
                    }
                }else{
                    arrConsumoMedia.fp = consumo.fp;
                    arrConsumoMedia.p = consumo.p;
                }
                for(var i=0;i<12;i++){
                    arrConsumo.push(arrConsumoMedia);
                }
                return arrConsumo;
            }
            function setConsumoHistorico(consumo,configuracao){
                function mediaHistorico(consumo,configuracao){
                    function addConsumoTipo(obj,consumo, tipo){
                        if(!obj.hasOwnProperty(tipo)){
                            return parseFloat(consumo);    
                        }else{
                            return parseFloat(obj[tipo]) + parseFloat(consumo);
                        }
                    }

                    var media = {};
                    var cont_abrir = 0; //Media para os meses não informados
                    consumo.forEach(function(mes){
                        if(mes.abrir){
                            cont_abrir++;
                            if(configuracao.grupo == "B"){
                                if(configuracao.modalidade.valor == "conv"){
                                    media.conv = addConsumoTipo(media,mes.consumo.conv,"conv");
                                }
                                if(configuracao.modalidade.valor == "branca"){
                                    media.fp = addConsumoTipo(media,mes.consumo.fp,"fp");
                                    media.int = addConsumoTipo(media,mes.consumo.int,"int");
                                    media.p = addConsumoTipo(media,mes.consumo.p,"p");
                                }
                            }else{
                                media.fp = addConsumoTipo(media,mes.consumo.fp,"fp");
                                media.p = addConsumoTipo(media,mes.consumo.p,"p");
                            }
                        }
                    });
                    if(configuracao.grupo == "B"){
                        if(configuracao.modalidade.valor == "conv"){
                            media.conv = media.conv/cont_abrir;
                        }
                        if(configuracao.modalidade.valor == "branca"){
                            media.fp =media.fp /cont_abrir;
                            media.int =media.int /cont_abrir;
                            media.p =media.p /cont_abrir;
                        }
                    }else{
                        media.fp =media.fp /cont_abrir;
                        media.p =media.p /cont_abrir;
                    }
                    return media;
                }
                function consumoAberto(consumo,configuracao){
                    if(configuracao.grupo == "B"){
                        if(configuracao.modalidade.valor == "conv"){
                            return {conv:consumo.conv};
                        }
                        if(configuracao.modalidade.valor == "branca"){
                            return {
                                fp : consumo.fp,
                                int : consumo.int,
                                p : consumo.p
                            };
                        }
                    }else{
                        return {
                            fp : consumo.fp,
                            p : consumo.p
                        };
                    }
                }

                var media = mediaHistorico(consumo,configuracao);
                var arrConsumoAnual = [];
                consumo.forEach(function(mes){
                    if(mes.abrir){
                        arrConsumoAnual.push(consumoAberto(mes.consumo,configuracao));
                    }else{
                        arrConsumoAnual.push(media);
                    }
                });
                return arrConsumoAnual;
            }

            if(media_ou_historico == "media"){
                return setConsumoMedia(consumo,configuracao);
            }
            if(media_ou_historico == "historico"){
                return setConsumoHistorico(consumo,configuracao);
            }
        }
    }
    set_listaMunicipiosConcessionarias(lista){
        this.municipios = lista.municipios;
        this.concessionarias = lista.concessionarias;
    }
    
    gerarResumo(){
        this.dados.localizacao = {
            endereco : this.input.endereco,
            endereco_num : this.input.endereco_num,
            endereco_comp : this.input.endereco_comp,
            cep : this.input.cep,
            uf : this.input.uf,
            municipio : {
                id : this.input.municipio,
                nome : this.procurarNome(this.municipios,this.input.municipio)
            }
        }

        this.dados.configuracao = {
            tipo_uc : this.tranfTipoUC(this.input.tipo_uc),
            concessionaria : {
                id : this.input.concessionaria,
                nome : this.procurarNome(this.concessionarias,this.input.concessionaria)
            }
        }
        let _configuracao = this.setConfiguracao(this.input.tipo_uc,{conv:this.input.conv,fp_p:this.input.fp_p,int:this.input.int});
        this.dados.configuracao.grupo = _configuracao.grupo;
        this.dados.configuracao.classe = _configuracao.classe;
        this.dados.configuracao.modalidade = _configuracao.modalidade;

        let media_ou_historico = this.input.mostrar_consumo_media?"media":"historico";
        let nome_media_ou_historico = media_ou_historico == "media"?"valores médios":"histórico";
        let consumo = (media_ou_historico == "media")?this.consumoToFloat(this.input.consumo_media,"media") : this.consumoToFloat(this.input.meses,"historico");
        this.dados.consumo = {
            media_ou_historico : {valor : media_ou_historico, nome : nome_media_ou_historico},
            meses : this.setConsumoAnual(media_ou_historico,consumo,this.dados.configuracao)
        };
    }

    geraDadosGrafico(){
        function cor(nome){
            switch(nome){
                case "vermelho": return "rgba(255,0,0, 1)";
                case "azul": return "rgba(56,176,222, 1)";
                case "verde": return "rgba(50,205,153,1)";
                case "preto": return "rgba(0, 0, 0, 1)";
                case "cinza": return "rgba(168,168,168, 1)";
                
                default: return "rgba(168,168,168, 1)";
            }
        }


        var arrDados = [];
        if(this.dados.configuracao.grupo == "B"){
            if(this.dados.configuracao.modalidade.valor == "conv"){
                arrDados = [{
                    label: "Convencional",
                    backgroundColor : cor("azul"),
                    data : []
                }];
                this.dados.consumo.meses.forEach(function(mes){
                    arrDados[0].data.push(mes.conv);
                });
            }
            if(this.dados.configuracao.modalidade.valor == "branca"){
                arrDados = [
                    {
                        label: "Fora da Ponta",
                        backgroundColor : cor("azul"),
                        data : []
                    },
                    {
                        label: "Interm.",
                        backgroundColor : cor("cinza"),
                        data : []
                    },
                    {
                        label: "Ponta",
                        backgroundColor : cor("verde"),
                        data : []
                    }
                ];
                this.dados.consumo.meses.forEach(function(mes){
                    arrDados[0].data.push(mes.fp);
                    arrDados[1].data.push(mes.int);
                    arrDados[2].data.push(mes.p);
                });
            }
        }else{
            arrDados = [
                {
                    label: "Fora da Ponta",
                    backgroundColor : cor("azul"),
                    data : []
                },
                {
                    label: "Na Ponta",
                    backgroundColor : cor("verde"),
                    data : []
                }
            ];
            this.dados.consumo.meses.forEach(function(mes){
                arrDados[0].data.push(mes.fp);
                arrDados[1].data.push(mes.p);
            });
        }
        return arrDados;
    }
}