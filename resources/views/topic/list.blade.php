@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="row">
                    <h2><b>Lista de temas</b></h2>
                    <hr/>
                </div>
                <div class="row">
                    <table class="table table-responsive table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="header text-center">Nº</th>
                            <th class="header text-center">Titulo</th>
                            <th class="header text-center">Descripción</th>
                            <th class="header text-center">Autor</th>
                            <th class="header text-center">Número de Comentarios</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($topics as $topic)
                            <tr>
                                <td class="text-center">{{ $topic['number'] }}</td>
                                <td><a href="/topic/view/{{ $topic['topicId'] }}">{{ $topic['title'] }}</a></td>
                                <td>{{ $topic['description'] }}</td>
                                <td class="text-center">{{ $topic['username'] }}</td>
                                <td class="text-center">{{ $topic['comment_count'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop