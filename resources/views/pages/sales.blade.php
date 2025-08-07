@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Sales'])
    @livewire('sales-controller')
@endsection