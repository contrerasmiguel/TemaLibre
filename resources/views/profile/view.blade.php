@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3 well">
                    <p><b>{{ $user->nombre }} {{ $user->apellido }}</b></p>
                    <p>{{ $user->nombre_usuario }}</p>
                </div>
                <div class="col-md-offset-1 col-md-8">
                    <div class="row well">
                        @if($topicSubscriptions->count() > 0)
                            <h4 class="text-center"><b>Temas que sigue {{ $user->nombre_usuario }}</b></h4>
                        </div>
                        <div id="topicsSubscribed" class="row">
                            <div class="col-md-12">
                                <table class="table table-responsive table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="header text-center">Nº</th>
                                        <th class="header text-center">Titulo</th>
                                        <th class="header text-center">Autor</th>
                                        <th class="header text-center">Número de Comentarios</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topicSubscriptions as $topicSubscription)
                                        <tr>
                                            <td class="text-center">{{ $topicSubscription['number'] }}</td>
                                            <td class="text-center"><a href="/topic/view/{{ $topicSubscription['topicSubscription']->topic->id_tema }}">{{ $topicSubscription['topicSubscription']->topic->titulo }}</a></td>
                                            <td class="text-center"><a href="/profile/view/{{ $topicSubscription['topicSubscription']->topic->user->id_usuario }}">{{ $topicSubscription['topicSubscription']->topic->user->nombre_usuario }}</a></td>
                                            <td class="text-center">{{ $topicSubscription['topicSubscription']->topic->comments->count() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                            <h4 class="text-center"><b>{{ $user->nombre_usuario }} no sigue ningún tema</b></h4>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ URL::asset('js/profile.js') }}"></script>
@stop