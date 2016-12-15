@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="row">
                    <h2><b>Edición de datos de usuario</b></h2>
                    <hr/>
                </div>
                <div class="row">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <form role="form">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="clave">Contraseña</label>
                                    <input class="form-control" type="password" name="clave">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="clave_confirmation">Confirmación de contraseña</label>
                                    <input class="form-control" type="password" name="clave_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="correo_electronico">Dirección de correo electrónico</label>
                                    <input class="form-control" type="email" name="correo_electronico" placeholder="Ejemplo: brianjch@gmail.com" value="{{ old('correo_electronico') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input class="form-control" type="text" name="nombre" placeholder="Ejemplo: Nelson" value="{{ old('nombre') }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input class="form-control" type="text" name="apellido" placeholder="Ejemplo: Rodríguez" value="{{ old('apellido') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pregunta_secreta">Pregunta secreta</label>
                                    <input class="form-control" type="text" name="pregunta_secreta" placeholder="Ejemplo: ¿En que año nací?" value="{{ old('pregunta_secreta') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="respuesta_secreta">Respuesta de la pregunta secreta</label>
                                    <input class="form-control" type="text" name="respuesta_secreta" placeholder="Ejemplo: 1994" value="{{ old('respuesta_secreta') }}">
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="col-md-offset-3 col-md-3">
                            <button type="submit" formaction="/profile/edit" formmethod="POST" class="btn btn-success btn-block">
                                <span class="glyphicon glyphicon-check"></span>&nbspCambiar datos
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="reset" class="btn btn-default btn-block">
                                <span class="glyphicon glyphicon-remove"></span>&nbspLimpiar campos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop