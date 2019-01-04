<script>
var listaMunicipiosConcessionarias = {};
var passos_gerais = {
    tipo_uc:'',
    endereco:'',
    endereco_num:'',
    endereco_comp:'',
    cep:'',
    uf:'',
    municipio:'',
    concessionaria:''
};
var form_consumo = {
        conv:false,
        fp_p:false,
        int:false,
        mostrar_consumo_media : false,
        mostrar_consumo_historico : false,
        grid_historico:'',
        meses:[
            {id:'jan',nome:'Jan',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'fev',nome:'Fev',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'mar',nome:'Mar',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'abr',nome:'Abr',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'mai',nome:'Mai',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'jun',nome:'Jun',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'jul',nome:'Jul',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'ago',nome:'Ago',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'set',nome:'Set',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'out',nome:'Out',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'nov',nome:'Nov',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
            {id:'dez',nome:'Dez',abrir:false, consumo:{conv:'',fp:'',int:'',p:''}},
        ],
        consumo_media:{conv:'',fp:'',int:'',p:''},
        abrir_todos:false
    };
</script>

{{-- **********************
Passos gerais
********************** --}}
<script id="templ_form_passo_gerais" type="text/x-jsrender">
    <div id='form_passo_gerais'>
        <h6 style="font-weight:bold">Dados gerais</h6>
        <div style='text-align:left' class='form_explicacao'>
            *Campos obrigatórios
        </div>
        <div class="form_inner_ctn">
            <div class="form_campos_width30 tam_box">
                <select data-link="tipo_uc" class="form-control texto-plataforma-cinza require_not_zero perfil" tagOutlaw = "perfil" name="tipo_uc" id="tipo_uc">
                    <option value="">Perfil*</option>
                    <option value="1">Residencial</option>
                    <option value="2">Rural</option>
                    <option value="3">Comercial ou Industrial</option>
                    <option value="4">Iluminação pública</option>
                </select>
            </div>
            <div class="form_campos_width70 tam_box">
                <input data-link="endereco" type="text" class="form-control texto-plataforma-cinza require_not_null endereco" tagOutlaw = "endereco" name="endereco_uc" id="endereco_uc" aria-describedby="" placeholder="Endereço*">
            </div>
        </div>
        <div class="form_inner_ctn">
            <div class="form_campos_width20 tam_box">
                <input data-link="endereco_num" type="text" class="form-control require_not_null endereco_num" tagOutlaw = "endereco_num" name="num_endereco_uc" id="num_endereco_uc" aria-describedby="" placeholder="Número*">
            </div>
            <div class="form_campos_width60 tam_box">
                <input data-link="endereco_comp" type="text" class="form-control" name="comp_endereco_uc" id="comp_endereco_uc" aria-describedby="" placeholder="Complemento">
            </div>
            <div class="form_campos_width20 tam_box">
                <input data-link="cep" type="text" class="form-control require_not_null require_zipcode cep" tagOutlaw = "cep" name="cep_uc" id="cep_uc" aria-describedby="" placeholder="CEP*">
            </div>
        </div>
        <div class="form_inner_ctn">
            <div class='form_campos_width10 tam_box'>
                <select data-link="uf" class="form-control require_not_zero uf" tagOutlaw = "uf" name="uf_uc" id="uf_uc" placeholder="">
                    <option value="">UF*</option>
                    @foreach($listaUFs as $uf)
                        <option value="{{$uf}}">{{$uf}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form_campos_width60 tam_box">
                <select data-link="municipio" class="form-control input_bloqueado require_not_zero cidade" tagOutlaw = "cidade" name="sel_cidade_endereco_uc" id="sel_cidade_endereco_uc" disabled >
                    <option value="">Cidade*</option>
                </select>
            </div>
            <div class="form_campos_width30 tam_box">
                <select data-link="concessionaria" class="form-control input_bloqueado require_not_zero concessionaria" tagOutlaw = "concessionaria" name="concessionaria_uc" id="concessionaria_uc" disabled>
                    <option value="">Companhia de energia*</option>
                </select>
            </div>
        </div>
        <br/>
        <center>
            <button id='btn_proximo_gerais' type="button" class="btn btn-primary">Próximo</button>
        </center>
    </div>
</script>
<script>
    
    var templ_form_passo_gerais = $.templates("#templ_form_passo_gerais");
    templ_form_passo_gerais.link("#ctn-tmpl-form_passo_gerais", passos_gerais);

    $('#cep_uc').mask('99999-999');
    $('#uf_uc').change(function(){
        if($('#uf_uc').val()!="0"){
            $('#sel_cidade_endereco_uc').append("<option value='-1'>Carregando...</option>");
            $('#sel_cidade_endereco_uc').val(-1);
            $('#sel_cidade_endereco_uc').prop('disabled',true);
            $('#sel_cidade_endereco_uc').addClass('input_bloqueado');

            $('#concessionaria_uc').append("<option value='-1'>Carregando...</option>");
            $('#concessionaria_uc').val(-1);
            $('#concessionaria_uc').prop('disabled',true);
            $('#concessionaria_uc').addClass('input_bloqueado');

            $.get('/plataforma/api/get_cidade_concessionaria/'+$(this).val())
                .done(function(data) {
                    listaMunicipiosConcessionarias = data;
                    $('#sel_cidade_endereco_uc').prop('disabled',false);
                    $('#sel_cidade_endereco_uc').removeClass('input_bloqueado');
                    $('#concessionaria_uc').prop('disabled',false);
                    $('#concessionaria_uc').removeClass('input_bloqueado');

                    get_list_form_from_json(data.municipios,'#sel_cidade_endereco_uc');
                    get_list_form_from_json(data.concessionarias,'#concessionaria_uc');
                });
        }else{
            $('#sel_cidade_endereco_uc').prop('disabled',true);
            $('#sel_cidade_endereco_uc').addClass('input_bloqueado');
            $('#sel_cidade_endereco_uc').children('option:not(:first)').remove();
            
            $('#concessionaria_uc').prop('disabled',true);
            $('#concessionaria_uc').addClass('input_bloqueado');
            $('#concessionaria_uc').children('option:not(:first)').remove();
        }
    });
    $('#btn_proximo_gerais').click(function(event){
        $.observable(validacao).refresh([]);
        $.observable(retorno_bd_ok).refresh([]);
        let r = new myLaws();
        r.add_law(
            {
                name:'regra1',
                ref:[
                    {name:'require_not_null'},
                    {name:'require_not_zero'}
                ],
                msg:'Campos obrigatórios.',
                style_outlaws:'alert-danger'
            }
        );
        r.add_law(
            {
                name:'regra2',
                ref:[
                    {name:'require_zipcode'}
                ],
                msg:'Forneça um CEP válido.',
                style_outlaws:'alert-danger'
            }
        );
        var _regras = r.get_laws();
        var _container = $('#form_passo_gerais');
        let v = new myJudge(_container,_regras);
        v.release_outlaws();
        v.work();
        $.observable(validacao).refresh(v.get_accusations());
        if(v.get_hasOutlaws()){
            event.preventDefault();
            v.arrest_outlaws();
            ir_para_msg_validacao('#container_msg_validacao');
        }else{
            $('.progress-bar').css('width','25%');
            $('.progress-bar').attr('aria-valuenow',25);
            $('#form_passo_gerais').addClass('esconder');
            $('#form_passo_consumo_tipo').removeClass('esconder');
            ir_para_msg_validacao('#container_msg_validacao');
        }
    });
</script>

{{-- ****************************
Consumo tipo
**************************** --}}
<script>
    $('#btn_proximo_consumo_tipo').click(function(event){
        let r = new myLaws();
        r.add_law(
            {
                name:'regra1',
                ref:[
                    {name:'require_one_check',tagOutlaw:"posto_tarifario"}
                ],
                msg:'Escolha pelo menos uma modalidade de consumo.',
                style_outlaws:'alert_check_box'
            }
        );
        var _regras = r.get_laws();
        var _container = $('#form_passo_consumo_tipo');
        let v = new myJudge(_container,_regras);
        v.release_outlaws();
        v.work();
        $.observable(validacao).refresh(v.get_accusations());
        if(v.get_hasOutlaws()){
            event.preventDefault();
            v.arrest_outlaws();
            ir_para_msg_validacao('#container_msg_validacao');
        }else{
            $('.progress-bar').css('width','50%');
            $('.progress-bar').attr('aria-valuenow',50);
            $('#form_passo_consumo_tipo').addClass('esconder');
            $('#form_passo_consumo').removeClass('esconder');
            ir_para_msg_validacao('#container_msg_validacao');
            $.observable(form_consumo).setProperty('conv', false);
            $.observable(form_consumo).setProperty('fp_p', false);
            $.observable(form_consumo).setProperty('int', false);
            if($('#check_conv')[0].checked){
                $.observable(form_consumo).setProperty('conv', true);
                $.observable(form_consumo).setProperty('grid_historico', 'grid-2');
            }
            
            if($('#check_int')[0].checked){
                $.observable(form_consumo).setProperty('fp_p', true);
                $.observable(form_consumo).setProperty('int', true);
                $.observable(form_consumo).setProperty('grid_historico', 'grid-4');
            }else{
                if($('#check_fp_p')[0].checked){
                    $.observable(form_consumo).setProperty('fp_p', true);
                    $.observable(form_consumo).setProperty('grid_historico', 'grid-3');
                }
            }
            var mudou=false;
            $('#form_passo_consumo_tipo input[type=checkbox]').change(function(){
                if(!mudou){
                    for(prop in form_consumo.consumo_media){
                        form_consumo.consumo_media[prop] = "";
                    }
                    form_consumo.meses.forEach(function(mes,index){
                        for(prop in mes.consumo){
                            mes.consumo[prop] = "";
                        }
                    });
                    mudou = true;
                }                
            });
        }
    });
    $('#check_fp_p').change(function(){
        if(this.checked) {
            $('#check_conv').prop('checked',false);
        }else{
            $('#check_int').prop('checked',false);
        }
    });
    $('#check_int').change(function(){
        if(this.checked) {
            $('#check_fp_p').prop('checked',true);
            $('#check_conv').prop('checked',false);
        }
    });
    $('#check_conv').change(function(){
        if(this.checked) {
            $('#check_fp_p').prop('checked',false);
            $('#check_int').prop('checked',false);
        }
    });
    $('#btn_anterior_consumo_tipo').click(function(event){
        $('.progress-bar').css('width','0%');
        $('.progress-bar').attr('aria-valuenow',0);
        ir_para_msg_validacao('#container_msg_validacao');
        $('#form_passo_consumo_tipo').addClass('esconder');
        $('#form_passo_gerais').removeClass('esconder');
    });
</script>

{{-- ********************************
Consumo média ou histórico
******************************** --}}
<script>
    $('#check_media_consumo').change(function(){
        if(this.checked){
            $('#check_historico').prop('checked',false);
        }
    });
    $('#check_historico').change(function(){
        if(this.checked){
            $('#check_media_consumo').prop('checked',false);
        }
    });
    $('#btn_proximo_consumo').click(function(event){
        let r = new myLaws();
        r.add_law(
            {
                name:'regra1',
                ref:[
                    {name:'require_one_check',tagOutlaw:"media_ou_historico"}
                ],
                msg:'Escolha como vai informar o seu consumo de energia.',
                style_outlaws:'alert_check_box'
            }
        );
        var _regras = r.get_laws();
        var _container = $('#form_passo_consumo');
        let v = new myJudge(_container,_regras);
        v.release_outlaws();
        v.work();
        $.observable(validacao).refresh(v.get_accusations());
        if(v.get_hasOutlaws()){
            event.preventDefault();
            v.arrest_outlaws();
            ir_para_msg_validacao('#container_msg_validacao');
        }else{
            $('.progress-bar').css('width','75%');
            $('.progress-bar').attr('aria-valuenow',75);
            $('#form_passo_consumo').addClass('esconder');
            $('#form_passo_consumo_valor').removeClass('esconder');
            $.observable(form_consumo).setProperty('mostrar_consumo_media', $('#check_media_consumo')[0].checked);
            $.observable(form_consumo).setProperty('mostrar_consumo_historico', $('#check_historico')[0].checked);
            if(form_consumo.mostrar_consumo_media){
                form_consumo.meses.forEach(function(mes, index){
                    mes.abrir = false;
                    mes.consumo.conv = "";
                    mes.consumo.fp = "";
                    mes.consumo.int = "";
                    mes.consumo.p = "";
                    // $.observable(form_consumo.meses[index]).setProperty('abrir', false);
                    // $.observable(form_consumo.meses[index].consumo).setProperty('conv', '');
                    // $.observable(form_consumo.meses[index].consumo).setProperty('fp', '');
                    // $.observable(form_consumo.meses[index].consumo).setProperty('int', '');
                    // $.observable(form_consumo.meses[index].consumo).setProperty('p', '');
                });
            }
            if(form_consumo.mostrar_consumo_historico){
                form_consumo.consumo_media.conv = "";
                form_consumo.consumo_media.fp = "";
                form_consumo.consumo_media.int = "";
                form_consumo.consumo_media.p = "";
                // $.observable(form_consumo.consumo_media).setProperty('conv', '');
                // $.observable(form_consumo.consumo_media).setProperty('fp', '');
                // $.observable(form_consumo.consumo_media).setProperty('int', '');
                // $.observable(form_consumo.consumo_media).setProperty('p', '');
            }
        }
    });
    $('#btn_anterior_consumo').click(function(event){
        $('.progress-bar').css('width','25%');
        $('.progress-bar').attr('aria-valuenow',25);
        ir_para_msg_validacao('#container_msg_validacao');
        $('#form_passo_consumo').addClass('esconder');
        $('#form_passo_consumo_tipo').removeClass('esconder');
    });
</script>

{{-- ****************************
Consumo valor
**************************** --}}
<script id="templ_consumo_historico" type="text/x-jsrender">
    [*[if mostrar_consumo_historico]]  
        <div>
            <p style="font-size:0.9em">Escolha os meses e preencha os valores para os quais você tem consumo de energia.</p>
            <center>
                <div data-link="class[:grid_historico]">
                    <div class="espacamento-grid-row" style="width:60px;">
                        Mês
                    </div>
                    [*[if conv]]
                    <div class="espacamento-grid-row">
                        Consumo
                    </div>
                    [[/if]]
                    [*[if fp_p]]
                    <div class="espacamento-grid-row" >
                        F. Ponta
                    </div>
                    [[/if]]
                    [*[if int]]
                    <div class="espacamento-grid-row">
                        Inter.
                    </div>
                    [[/if]]
                    [*[if fp_p]]
                    <div class="espacamento-grid-row">
                        Ponta
                    </div>
                    [[/if]]
                    [[for meses]]
                        <div class="espacamento-grid-row" style="width:60px;text-align:left">
                            <input type="checkbox" data-link="abrir" class="mes_[[:id]] check_mes require_one_check" name="check_mes_consumo_[[:id]]" id="check_mes_consumo_[[:id]]" value="checkedValue" unchecked>
                            <label style="padding-left:3px" for="check_mes_consumo_[[:id]]" class="tag_mes_consumo">[[:nome]]</label>
                        </div>
                        [*[if ~root.conv]]
                            <div class="espacamento-grid-row" style="width:100%">
                                    <input type="text" data-link="[:consumo.conv:] class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado tam_box require_num tag_historico_conv_[[:id]]" tagOutlaw="tag_historico_conv_[[:id]]" name="consumo_conv_[[:id]]" id="consumo_conv_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                        [*[if ~root.fp_p]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="[:consumo.fp:] class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado tam_box require_num tag_historico_fp_[[:id]]" tagOutlaw="tag_historico_fp_[[:id]]" name="consumo_fp_[[:id]]" id="consumo_fp_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                        [*[if ~root.int]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="[:consumo.int:] class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado  tam_box require_num tag_historico_int_[[:id]]" tagOutlaw="tag_historico_int_[[:id]]" name="consumo_int_[[:id]]" id="consumo_int_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                        [*[if ~root.fp_p]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="[:consumo.p:] class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado tam_box require_num tag_historico_p_[[:id]]" tagOutlaw="tag_historico_p_[[:id]]" name="consumo_p_[[:id]]" id="consumo_p_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                    [[/for]]
                </div>
            </center>
        </div>
    [[/if]]
</script>
<script id="templ_consumo_media" type="text/x-jsrender">
    [*[if mostrar_consumo_media]]
        <center>
            <div style="display:grid;max-width:500px;">
                [*[if conv]]
                    <div class="grid-row-consumo-media">
                        <label for="consumo_media_conv">Consumo</label>
                        <input type="text" data-link="consumo_media.conv"
                            class="form-control require_num require_sum_ge tag_media_conv tag_media_valor" tagOutlaw="tag_media_conv" name="consumo_media_conv" id="consumo_media_conv" placeholder="">
                    </div>
                [[/if]]
                [*[if fp_p]]
                    <div class="grid-row-consumo-media">
                        <label for="consumo_media_fp">Fora da Ponta</label>
                        <input type="text" data-link="consumo_media.fp"
                            class="form-control require_num require_sum_ge tag_media_fp tag_media_valor"  tagOutlaw="tag_media_fp" name="consumo_media_fp" id="consumo_media_fp" placeholder="">
                    </div>
                [[/if]]
                [*[if int]]
                    <div class="grid-row-consumo-media">
                        <label for="consumo_media_int">Intermediário</label>
                        <input type="text" data-link="consumo_media.int"
                            class="form-control require_num require_sum_ge tag_media_int tag_media_valor"  tagOutlaw="tag_media_int" name="consumo_media_int" id="consumo_media_int" placeholder="">
                    </div>
                [[/if]]
                [*[if fp_p]]
                    <div class="grid-row-consumo-media">
                        <label for="consumo_media_p">Ponta</label>
                        <input type="text" data-link="consumo_media.p"
                            class="form-control require_num require_sum_ge tag_media_p tag_media_valor"  tagOutlaw="tag_media_p" name="consumo_media_p" id="consumo_media_p" placeholder="">
                    </div>
                [[/if]]  
            </div>
        </center>
    [[/if]]
</script>
<script>
    
    var tmpl_consumo_historico = $.templates("#templ_consumo_historico");
    tmpl_consumo_historico.link("#ctn-tmpl-consumo-historico", form_consumo);

    var tmpl_consumo_media = $.templates("#templ_consumo_media");
    tmpl_consumo_media.link("#ctn-tmpl-consumo-media", form_consumo);

    $('#btn_proximo_consumo_valor').click(function(event){
        if(form_consumo.mostrar_consumo_media){
            let r = new myLaws();
            r.add_law(
                {
                    name:'regra2',
                    ref:[
                        {name:'require_num'}
                    ],
                    msg:'Seu consumo precisa ser um número.',
                    style_outlaws:'alert-danger'
                }
            );
            r.add_law(
                {
                    name:'regra3',
                    ref:[
                        {name:'require_sum_ge',tagOutlaw:"tag_media_valor",val:0}
                    ],
                    msg:'Seu consumo não pode ser zero.',
                    style_outlaws:'alert-danger'
                }
            );
            var _regras = r.get_laws();
            var _container = $('#form_passo_consumo_valor');
            let v = new myJudge(_container,_regras);
            v.release_outlaws();
            v.work();
            $.observable(validacao).refresh(v.get_accusations());
            if(v.get_hasOutlaws()){
                event.preventDefault();
                v.arrest_outlaws();
                ir_para_msg_validacao('#container_msg_validacao');
            }else{
                $('.progress-bar').css('width','100%');
                $('.progress-bar').attr('aria-valuenow',100);
                $('#form_passo_consumo_valor').addClass('esconder');
                $('#form_passo_resumo').removeClass('esconder');
            }
        }
        if(form_consumo.mostrar_consumo_historico){
            let r = new myLaws();
            r.add_law(
                {
                    name:'regra1',
                    ref:[
                        {name:'require_one_check',tagOutlaw:"tag_mes_consumo"}
                    ],
                    msg:'Abra pelo menos 1 mês para preencher o consumo.',
                    style_outlaws:'alert_check_box'
                }
            );
            r.add_law(
                {
                    name:'regra3',
                    ref:[
                        {name:'require_num'}
                    ],
                    msg:'Seu consumo precisa ser um número.',
                    style_outlaws:'alert-danger'
                }
            );
            r.add_law(
                {
                    name:'regra4',
                    ref:[
                        {name:'require_sum_ge',tagOutlaw:"tag_historico_valor",val:0}
                    ],
                    msg:'Seu consumo não pode ser zero.',
                    style_outlaws:'alert-danger'
                }
            );
            var _regras = r.get_laws();
            var _container = $('#form_passo_consumo_valor');
            let v = new myJudge(_container,_regras);
            v.release_outlaws();
            v.work();
            $.observable(validacao).refresh(v.get_accusations());
            if(v.get_hasOutlaws()){
                event.preventDefault();
                v.arrest_outlaws();
                ir_para_msg_validacao('#container_msg_validacao');
            }else{
                $('.progress-bar').css('width','100%');
                $('.progress-bar').attr('aria-valuenow',100);
                $('#form_passo_consumo_valor').addClass('esconder');
                $('#form_passo_resumo').removeClass('esconder');
            }
        }
        
    });
    $('#btn_anterior_consumo_valor').click(function(event){
        $('.progress-bar').css('width','50%');
        $('.progress-bar').attr('aria-valuenow',50);
        ir_para_msg_validacao('#container_msg_validacao');
        $('#form_passo_consumo_valor').addClass('esconder');
        $('#form_passo_consumo').removeClass('esconder');
    });
</script>


{{-- *********************
Resumo
********************* --}}
<style>
    .CadastrarUC__grafico{
        position: relative;
        margin: auto;
        height: 300px;
        width: 100%;
        border:1px solid lightgrey; 
        border-radius:5px; 
        padding:3px;
    }
    .CadastrarUC_bloco{
        margin:3px;
    }
    .CadastrarUC_blocoTexto{
        width:40%;
    }
    .CadastrarUC_blocoGrafico{
        width:50%;
    }

    @media screen and (max-width: 700px) {
        .CadastrarUC_blocoTexto{
            width:100%;
        }
        .CadastrarUC_blocoGrafico{
            width:100%;
            margin-top:5px
        }
        .CadastrarUC__grafico{
            height: 200px;
        }
        .chartjsLegend ul{
            flex-direction:column;
        }
    }
}
</style>
<script id="templ_form_passo_resumo" type="text/x-jsrender">
    <center>
        <div>
            <div id="passo_resumo" class="container-resumoCadastroUC">
                <h6 style="font-weight:bold; text-align:center;">Verifique os dados</h6>
                <br/>
                <p style="text-align:left">
                    Com base nas suas informações, nós obtemos os seguintes resultados sobre a configuração da sua unidade consumidora (você pode voltar a qualquer momento e corrigir os dados):
                </p>
                <div class="container">
                    <div class="d-inline-block align-top CadastrarUC_bloco CadastrarUC_blocoTexto">
                        <div style="text-align:left">
                            <strong>Endereço</strong>
                            <br/>
                            <ul class="list-group" >
                                <li class="list-group-item">
                                    [*[>localizacao.endereco]],
                                    [*[>localizacao.endereco_num]],
                                    [*[if localizacao.endereco_comp != ""]] [*[>localizacao.endereco_comp]], [[/if]]
                                    [*[>localizacao.municipio.nome]],
                                    [*[>localizacao.uf]],
                                    CEP: [*[>localizacao.cep]]
                                </li>
                            </ul>
                        </div>
                        <div style="text-align:left;margin-top:5px">
                            <strong>Configuração</strong>
                            <br/>
                            <ul class="list-group">
                                <li class="list-group-item">Concessionária: [*[>configuracao.concessionaria.nome]]</li>
                                <li class="list-group-item">Perfil: [*[>configuracao.tipo_uc]]</li>
                                <li class="list-group-item">Grupo: [*[>configuracao.grupo]]</li>
                                <li class="list-group-item">Classe: [*[>configuracao.classe]]</li>
                                [*[if configuracao.modalidade.nome]]
                                    <li class="list-group-item">Modalidade: [*[>configuracao.modalidade.nome]]</li>
                                [[/if]]
                            </ul>
                        </div>
                    </div>
                    <div class="d-inline-block align-top CadastrarUC_bloco CadastrarUC_blocoGrafico" style="text-align:left">
                        <strong>Consumo em kWh ([*[>consumo.media_ou_historico.nome]])</strong>
                        <br/>
                        <div class="CadastrarUC__grafico">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <br/><br/>
                <center>
                    <button id='btn_anterior_resumo' type="button" class="btn btn-light">Anterior</button>
                    <button id='btn_concluir' type="button" class="btn btn-success">Concluir</button>
                </center>
            </div>
        </div>
    </center>
</script>
<script>
    var dadosForm = {};
    var dadosResumo = {};
    var dadosGrafico = {};
    $('#btn_proximo_consumo_valor').click(function(event){
        event.preventDefault();
        
        for(el in passos_gerais){
            dadosForm[el] = passos_gerais[el];
        }
        for(el in form_consumo){
            dadosForm[el] = form_consumo[el];
        } 
        var uc = new UnidadeConsumidora(dadosForm);
        uc.set_listaMunicipiosConcessionarias(listaMunicipiosConcessionarias);
        uc.gerarResumo();
        dadosResumo = uc.getDados();
        dadosGrafico = uc.geraDadosGrafico();
        
        var templ_form_passo_resumo = $.templates("#templ_form_passo_resumo");
        templ_form_passo_resumo.link("#ctn-tmpl-form_passo_resumo", dadosResumo);
        
        var myChart = new Chart($('#myChart'), {
            type: 'bar',
            data: {
                labels: ["Jan", "Fev", "Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                datasets: dadosGrafico
            },
            options: {
                legend:{
                    position: "bottom",
                    labels:{
                        boxWidth:20
                    }
                },
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        
                        stacked: true
                    }]
                },
                responsive:true,
                maintainAspectRatio: false
            }
        });

        $('#btn_concluir').click(function(event){
            $('#form_add_uc').submit();
        });
        $('#btn_anterior_resumo').click(function(event){
            $('.progress-bar').css('width','75%');
            $('.progress-bar').attr('aria-valuenow',75);
            ir_para_msg_validacao('#container_msg_validacao');
            $('#form_passo_resumo').addClass('esconder');
            $('#form_passo_consumo_valor').removeClass('esconder');
        });
    });
   
</script>