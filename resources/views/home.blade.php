@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Fifa WorldCup 2018 Qualified Teams</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        @if(count($Team))
                        <table class="table table-bordered table-striped datatable" id="table-2">
                            <thead>
                            <tr>

                                <th style="text-align: center; font-size:16px;">Team Id</th>
                                <th style="text-align: center; font-size:16px;">Team Name</th>
                                <th style="text-align: center; font-size:16px;">Group Name</th>
                                <th style="text-align: center; font-size:16px;">Option</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($Team as $Teams)

                            <tr style="text-align:center;">

                                <td>{{$Teams->id}}</td>
                                <td>{{$Teams->team_name}}</td>
                                <td>{{$Teams->group_name}}</td>

                                <td>
                                    <a href="#" class="btn btn-default btn-sm btn-icon icon-left">
                                        <i class="entypo-pencil"></i>
                                        Edit
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left">
                                        <i class="entypo-cancel"></i>
                                        Delete
                                    </a>

                                    <a href="#" class="btn btn-info btn-sm btn-icon icon-left">
                                        <i class="entypo-info"></i>
                                        View
                                    </a>
                                </td>

                            </tr>

                            @endforeach

                            </tbody>
                        </table>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
