@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row vertical-center">
            <div class="col-md-offset-2 col-md-8">
                <div class="col-md-6">
                    <h1><b>TemaLibre</b></h1>
                    <p class="text-justify">Aplicación web que permite al usuario crear, seguir, organizar y eliminar temas.</p>
                </div>
                <div class="col-md-offset-1 col-md-5">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form role="form">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="form-group">
                                <label for="nombre_usuario">Nombre de usuario</label>
                                <input type="text" class="form-control" name="nombre_usuario" value="{{ old('nombre_usuario') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember">Recordar sesión</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" formaction="/auth/login" formmethod="POST" class="btn btn-primary btn-block">
                                    <span class="glyphicon glyphicon-log-in"></span>&nbspIniciar sesión
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" formaction="/auth/register" formmethod="GET" class="btn btn-default btn-block">
                                    <span class="glyphicon glyphicon-plus"></span>&nbspRegistrarse
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <a href="/auth/recover">Recuperar cuenta de usuario</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop