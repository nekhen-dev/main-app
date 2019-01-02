@extends('layouts.geral')

@section('titulo','Nekhen')

@section('css-include')
	<link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section('cor-fundo','#8FAADC')

@section('conteudo')
	<div style="padding-bottom:5vw;background-color: inherit;"></div>
	<!-- ********************************************************* -->
	<!-- Começa a parte de conteúdo -->
	<div class="intro">
		<h1>A revolução energética no Brasil</h1>
		<h3>Encontre os melhores desenvolvedores de projeto, promova sua central geradora e disponibilize seus serviços de construção.</h3>
		<img src="/img/fig-gd.png" width=100% height="auto"/>
	</div>
@endsection