@extends('layouts.app')

@section('content')
<h1>From laravel: {{ $id }}</h1>
<h2>{{ $event->title }}</h2>
<h3>{{ $event->description }}</h3>
    
@endsection