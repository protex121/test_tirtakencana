@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Toko'])
    @livewire('toko-controller')
@endsection