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
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="usernameOrEmail">Nombre de usuario o correo electrónico</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="usernameOrEmail" value="{{ old('usernameOrEmail') }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" formmethod="post" formaction="/auth/recover" class="btn btn-info btn-block">
                                        <span class="glyphicon glyphicon-search"></span>&nbsp;Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop