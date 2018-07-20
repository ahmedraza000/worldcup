@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card-body">
        <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>
    <div class="card-body">
        <passport-authorized-clients></passport-authorized-clients>
    </div>
    </div>
</div>
@endsection
