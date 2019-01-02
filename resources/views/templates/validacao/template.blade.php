<script>
    // Configura os delimitadores do JViews
    $.views.settings.delimiters("[[", "]]", "*");
</script>
<!-- Validação de formulario -->
<script id="template_validacao" type="text/x-jsrender">
    [*[if outLaws.length]]
        <div class="alert alert-danger" style="font-size:0.9em;text-align:center;" role="alert">
            <ul class="lista_validacao">
                [*[for outLaws]]
                    <li>[*[>lawMsg]]</li>
                [[/for]]
            </ul>
        </div>
    [[/if]]
</script>
<script id="template_retorno_bd_ok" type="text/x-jsrender">
    [*[if retorno_ok.length]]
        <div class="alert alert-success" style="font-size:0.9em;text-align:center;" role="alert">
            <ul class="lista_validacao">
                [*[for retorno_ok]]
                    <li>[*[>lawMsg]]</li>
                [[/for]]
            </ul>
        </div>
    [[/if]]
</script>
<script>
var msg_servidor={};
@if (session('msg.status') && session('msg.texto'))
    msg_servidor.status = {{session('msg.status')}} ;
    msg_servidor.texto = "{{session('msg.texto')}}" ;
    {{session()->forget('msg.status')}}
    {{session()->forget('msg.texto')}}
@endif
var validacao = [];
var retorno_bd_ok = [];
if(msg_servidor.hasOwnProperty("status")){
    if(msg_servidor.status == 200){
        var validacao_bd = [
            {
                retorno_ok:[
                    {law: "retorno_bd", lawMsg: msg_servidor.texto}
                ]
            }
        ];
        $.observable(retorno_bd_ok).refresh(validacao_bd);
    }else{
        var validacao_bd = [
            {
                outLaws:[
                    {law: "retorno_bd", lawMsg: msg_servidor.texto}
                ]
            }
        ];
        $.observable(validacao).refresh(validacao_bd);
    }
}
var tmpl1 = $.templates("#template_validacao");
tmpl1.link("#msg_validacao1", validacao);

var tmpl2 = $.templates("#template_retorno_bd_ok");
tmpl2.link("#msg_validacao2", retorno_bd_ok);
</script>