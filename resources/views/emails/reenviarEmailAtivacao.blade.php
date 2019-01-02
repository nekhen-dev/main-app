<h1>Bem vindo à Nekhen</h1>

<p>{{ $dados->destinatario }}, você recebeu este e-mail por ter solicitado o reenvio do link de ativação do cadastro.</p>
<p>Para concluir seu cadastro, acesse o link abaixo:</p>
<a href="{{ $dados->link }}">{{ $dados->link }}</a>