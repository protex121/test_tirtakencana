@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Area'])
    @livewire('area-sales-controller')
@endsection