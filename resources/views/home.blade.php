@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @if(Session::has('store-success'))
                <p class="alert alert-success">{{ Session::get('store-success') }}</p>
                <p class="alert alert-info">Shortened: {{ url('/', ['code' => app('request')->input('code')]) }}</p>
            @endif

            @if(Session::has('store-danger'))
                <p class="alert alert-danger">{{ Session::get('store-danger') }}</p>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">Shorten your URL!</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('urls.store') }}">
                        {{ csrf_field() }}

                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}" placeholder="Insert your url here..." required autofocus>

                            @if ($errors->has('url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-info">
                                Go!
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            @if(Session::has('destroy-success'))
                <p class="alert alert-success">{{ Session::get('destroy-success') }}</p>
            @endif

            @if(Session::has('destroy-danger'))
                <p class="alert alert-danger">{{ Session::get('destroy-danger') }}</p>
            @endif
            
            <div class="panel panel-info">
                <div class="panel-heading">Your URLs</div>

                <div class="panel-body">
                    @if(count($urls) === 0)
                        <p class="alert alert-default">You have no URLs currently...</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Code</th>
                                        <th>Clicks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($urls as $url)
                                        <tr>
                                            <td>{{ $url->url }}</td>
                                            <td>{{ $url->code }}</td>
                                            <td>{{ $url->clicks }}</td>
                                            <td>
                                                {{ Form::open(['route' => ['urls.destroy', $url->id], 'method' => 'delete']) }}
                                                    <button type="submit" class="btn" onclick="return confirm('Are you sure?')">Delete</button>
                                                {{ Form::close() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
