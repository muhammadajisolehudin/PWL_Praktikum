@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            < class="card">

                <div class="card-header">{{_('dashboard')}}</div>
                    
                <div class="card-body">
                    @if($user->roles_id == 1)
                     anda login sebagai Admin
                    @else
                     anda login sebagai user
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
