@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="row">
                    <h2><b>Lista de usuarios</b></h2>
                    <hr/>
                </div>
                <div class="row">
                    <table class="table table-responsive table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="header text-center">Nombre de Usuario</th>
                            <th class="header text-center">Fecha de Registro</th>
                            <th class="header text-center">Tipo de Usuario</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users->sortByDesc('fecha_registro') as $user)
                            <tr>
                                <td class="text-center"><a href="/profile/view/{{ $user->id_usuario }}">{{ $user->nombre_usuario }}</a></td>
                                <td class="text-center">{{ $user->fecha_registro }}</td>
                                <td class="text-center">
                                    @if(\App\Administrator::all()->where('id_administrador'
                                        , $user->id_usuario)->count() > 0)
                                        Administrador
                                    @else
                                        Usuario común
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop