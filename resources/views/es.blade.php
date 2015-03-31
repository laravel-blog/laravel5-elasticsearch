@extends('app')



@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Artikelübersicht</div>
                    <form action="{{url('/')}}" method="get">
                        <div class="input-group col-md-10 col-md-offset-1" style="margin-top: 10px">

                            <input type="text" class="form-control" placeholder="Suche" name="q" value="{{ $query }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="submit">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>

                        </div>
                    </form>

                    <div class="panel-body">
                        @if(count($articles))
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Titel</th>
                                        <th>Kurzbeschreibung</th>
                                        <th>Preis</th>
                                        <th>Steuern</th>
                                    </tr>
                                    @foreach($articles as $article)
                                        <tr>
                                            <td>{{ $article->id }}</td>
                                            <td>{{ $article->title }}</td>
                                            <td>{{ $article->short_desc }}</td>
                                            <td>{{ $article->price }}</td>
                                            <td>{{ $article->vat }}%</td>
                                        </tr>
                                    @endforeach
                                </table>
                                {!! $articles->render() !!}
                            </div>
                        @else
                            <p>Leider keine Daten vorhanden</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection