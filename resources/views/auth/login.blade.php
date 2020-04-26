@extends('layouts.auth')

@section('css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col s12  m12 l12 center-align logo-box">
            <h1 class="white-text">GESTOR BOVINO</h1>
        </div>
    </div>
    <div class="row ">
        <div class="col s12 m12 l12 center-align login-content">
            <div class="card hoverable card-login">
                <form id="form-login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card-content">
                        <span class="card-title">Acesse sua conta</span>
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="cof">Email</label>
                                <input type="email" class="validate" required name="email" id="email"/>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12">
                                <label for="password">Senha</label>
                                <input type="password" minlength="6" class="validate" required name="password"
                                       id="password"/>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <button type="submit" class="btn green waves-effect waves-light btnsubmit">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
