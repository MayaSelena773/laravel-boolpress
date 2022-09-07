@extends('layouts.dashboard')

@section('content')
<div class="container">
<h1>Ciao sono la dashboard privata ;-)</h1> 

<div>Benvenuto {{ $user->name}}</div>
<div>La tua email è {{ $user->email}}</div>
</div>
@endsection