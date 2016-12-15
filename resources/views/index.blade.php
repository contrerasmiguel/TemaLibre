@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3 well">
                    <p><b>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</b></p>
                    <p>{{ Auth::user()->nombre_usuario }}</p>
                    <hr/>
                    <p><a href="/profile/edit">Editar perfil</a></p>
                    <p><a href="/auth/logout">Cerrar sesión</a></p>
                    <hr/>
                    <form>
                        <button type="submit" formmethod="get" formaction="/topic/create" class="btn btn-info btn-default btn-block">
                            <span class="glyphicon glyphicon-plus"></span>&nbsp;<b>Crear tema</b>
                        </button>
                    </form>
                </div>
                <div class="col-md-offset-1 col-md-8">
                    <div class="row well">
                        @if(Auth::user()->topicSubscriptions->where('activo', 1)->count() == 0)
                            <div class="col-md-offset-3 col-md-6">
                                <form>
                                    <button type="submit" formmethod="get" formaction="/topic/list" class="btn btn-success btn-default btn-block">
                                        <b>Escoge tus temas</b>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="col-md-6">
                                <button id="recentCommentsButton" type="button" class="btn btn-success btn-default btn-block">
                                    <b>Comentarios recientes</b>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button id="topicsSubscribedButton" type="button" class="btn btn-default btn-block">
                                    <b>Temas seguidos</b>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div id="recentComments" class="row">
                        @foreach($comments as $comment)
                            <div class="row well">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b><a href="/profile/view/{{ $comment->user->id_usuario }}">{{ $comment->user->nombre_usuario }}</a> en <a href="/topic/view/{{ $comment->topic->id_tema }}">{{ $comment->topic->titulo }}</a></b></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right">{{ $comment->fecha_creacion }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $comment->contenido_comentario }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="topicsSubscribed" hidden="hidden" class="row">
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
                                    <td class="text-center"><a href="/topic/view/{{ $topicSubscription['topicSubscription']->topic->tema_id }}">{{ $topicSubscription['topicSubscription']->topic->titulo }}</a></td>
                                    <td class="text-center"><a href="/profile/view/{{ $topicSubscription['topicSubscription']->topic->user->id_usuario }}">{{ $topicSubscription['topicSubscription']->topic->user->nombre_usuario }}</a></td>
                                    <td class="text-center">{{ $topicSubscription['topicSubscription']->topic->comments->count() }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ URL::asset('js/profile.js') }}"></script>
@stop