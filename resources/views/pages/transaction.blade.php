@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Transaction'])
    @livewire('transaction-controller')
@endsection