<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name') }} | {{ $title }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/app.css') }}">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('public/semanticUI/semantic/out/semantic.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/semantic.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/reset.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/site.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/container.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/grid.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/header.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/image.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/divider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/dropdown.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/segment.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/form.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/input.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/button.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/list.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/message.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/icon.css') }}">
        <script src="{{ asset('public/semanticUI/semantic/out/components/form.js') }}"></script>
        <script src="{{ asset('public/semanticUI/semantic/out/components/transition.js') }}"></script>
        <script src="{{ asset('public/semanticUI/semantic/out/components/dropdown.js') }}"></script>
        <script>
            $('.ui.sidebar').sidebar('toggle');
        </script>
    </head>
    <body>
        @if ($showHeader)
            <div class="ui top attached menu">
                <a href="{{ route('home') }}" class="item">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <div class="right menu">
                    @if (\Auth::check())
                @if ((Auth::user()->type == "admin") || (Auth::user()->type == "master"))
                    <a href="{{ route('itemForm')}}" class="item">Create Item</a>
                    <a href="{{ route('manageUsers')}}" class="item">Manage Users</a>
                @endif
                    <a href="{{ route('cart') }}" class="item">
                        <i class="shopping cart icon"></i>
                    </a>
                    @endif
                    <form class="ui right aligned category search item" method="POST" action="{{ route('home') }}">
                        @csrf
                        <div class="ui transparent icon input">
                            <input class="prompt" type="text" placeholder="Search items..." name="searchKey" value="{{ $searchKey }}">
                            <i class="search link icon"></i>
                        </div>
                        <div class="results"></div>
                    </form>
                    @if (\Auth::check())
                    <a href="{{ route('logout')}}" class="item">Logout</a>
                    @else
                    <a href="{{ route('login')}}" class="item">Login</a>
                    @endif
                </div>
            </div>
            <div class="ui bottom attached segment">
                <p></p>
            </div>
        @endif
        @yield('content')
    </body>
</html>
