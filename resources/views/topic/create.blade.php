@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="row">
                    <h2><b>Creación de un nuevo tema</b></h2>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Título del tema</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Descripción del tema</label>
                                        <textarea class="form-control" rows="3" name="description" value="{{ old('description') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="col-md-offset-2 col-md-4">
                            <button type="submit" formaction="/topic/create" formmethod="POST" class="btn btn-success btn-block">
                                <span class="glyphicon glyphicon-check"></span>&nbspLanzar tema
                            </button>
                        </div>
                        <div class="col-md-4">
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