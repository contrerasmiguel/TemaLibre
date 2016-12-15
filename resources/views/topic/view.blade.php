@extends('layouts.master')

@section('head')
    <meta name="_token" content="{!! csrf_token() !!}"/>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="row">
                    <h2 class="text-center"><b>{{ $topicData['title'] }}</b></h2>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 text-center">
                        <input type="hidden" id="topicIdInput" value="{{ $topicData['topicId'] }}"/>
                        <input type="hidden" id="userIdInput" value="{{ Auth::user()->id_usuario }}"/>

                        <button id="subscribeButton" type="button" class="btn btn-block @if($topicData['subscribed'] == false) btn-subscribe btn-success @else btn-unsubscribe btn-danger @endif">
                            @if($topicData['subscribed'] == false) Seguir @else Dejar de seguir @endif
                        </button>
                    </div>
                </div>
                @if($topicData['isAdministrator'] || $topicData['isTopicAuthor'])
                    <br/>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4 text-center">
                            <form>
                                {{ csrf_field() }}
                                <input name="topicId" type="hidden" value="{{ $topicData['topicId'] }}"/>
                                <input name="userId" type="hidden" value="{{ Auth::user()->id_usuario }}"/>
                                <button id="deleteTopicButton" formmethod="post" formaction="/topic/remove" type="submit" class="btn btn-block btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span>&nbsp;Eliminar tema
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
                <br/>
                <div class="row">
                    <div class="row well">
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>{{ $topicData['username'] }}</b></p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-right">{{ $topicData['date'] }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>{{ $topicData['content'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
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
                    <div class="col-md-offset-1 col-md-10">
                        <form role="form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="comment_content">Comentario</label>
                                        <textarea class="form-control" rows="3" name="comment_content" placeholder="Escriba aquí su comentario." value="{{ old('description') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input name="topicId" type="hidden" value="{{ $topicData['topicId'] }}">
                            <div class="col-md-offset-1 col-md-5">
                                <button type="submit" formaction="/comment/create" formmethod="POST" class="btn btn-success btn-block">
                                    <span class="glyphicon glyphicon-check"></span>&nbspPublicar comentario
                                </button>
                            </div>
                            <div class="col-md-5">
                                <button type="reset" class="btn btn-default btn-block">
                                    <span class="glyphicon glyphicon-remove"></span>&nbspLimpiar campo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                @if($topicData['comments']->count() > 0)
                    <div class="row">
                        <h3><b>Comentarios</b></h3>
                        <br/>
                        @foreach($topicData['comments'] as $comment)
                            <div class="row well">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><b>{{ $comment['username'] }}</b></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right">{{ $comment['date'] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $comment['content'] }}</p>
                                    </div>
                                </div>
                                @if($comment['isCommentAuthor'] || $topicData['isAdministrator'])
                                <div class="row">
                                    <div class="col-md-offset-9 col-md-3">
                                        <form>
                                            {{ csrf_field() }}
                                            <input name="commentId" type="hidden" value="{{ $comment['commentId'] }}"/>
                                            <input name="userId" type="hidden" value="{{ Auth::user()->id_usuario }}"/>
                                            <button id="deleteCommentButton" formmethod="post" formaction="/comment/remove" type="submit" class="btn btn-block btn-danger">
                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Eliminar comentario
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script src="{{ URL::asset('js/subscribe.js') }}"></script>
@stop