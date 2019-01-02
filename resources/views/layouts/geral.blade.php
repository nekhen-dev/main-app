<!DOCTYPE html>
<html>
	<head>
        
        <title>@yield('titulo')</title>
        @include('header')
        @yield('css-include')
        @yield('js-include')
        @yield('csrf-token')
		{{-- <link rel="stylesheet" href="/css/geral.css">
        <link rel="stylesheet" href="/css/intro.css"> --}}
	</head>
    {{-- <body style="background-color:#8FAADC"> --}}
            <body style="background-color:@yield('cor-fundo')">
		<div>
            @include('topbar')

            @yield('conteudo')
            
            @include('rodape')
		</div>
    </body>
    @yield('scripts')
</html>