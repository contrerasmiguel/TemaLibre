@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="row">
                    <h2><b>Recuperación de cuenta de usuario</b></h2>
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
                        {{ csrf_field() }}
                        <input name="userId" type="hidden" value="{{ $user->id_usuario }}"/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="secretAnswer">{{ $user->pregunta_secreta }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="secretAnswerInput">
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="newPassword">Nueva contraseña</label>
                                        <input class="form-control" type="password" name="newPassword">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="newPassword_confirmation">Confirmación de contraseña</label>
                                        <input class="form-control" type="password" name="newPassword_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" formmethod="post" formaction="/auth/password" id="changePasswordButton" class="btn btn-success btn-block">
                                    <span class="glyphicon glyphicon-check"></span>&nbsp;Cambiar contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop