@extends('layouts.app')

@section('title', 'index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            <!-- ------------------------------------------------------------------------------------------ -->
            <!-- This view is now being used in conjuction with the fail safe route so it needs to be blank -->
            <!-- -->
            <!-- <div class="card">                                         -->
            <!--                                                            --> 
            <!--    <div class="card-header">{{ __('Dashboard') }}</div>    -->
            <!--                                                            -->
            <!--    <div class="card-body">                                 -->
            <!--        @if (session('status'))                             -->
            <!--            <div class="alert alert-success" role="alert">  -->
            <!--                {{ session('status') }}                     -->
            <!--            </div>                                          -->
            <!--        @endif                                              -->
            <!--                                                            -->
            <!--       {{ __('Laravel BnB!') }}                             -->
            <!--    </div>                                                  -->
            <!--                                                            -->
            <!-- </div>                                                     -->
            <!-- ------------------------------------------------------------------------------------------ -->


        </div>
    </div>
</div>
@endsection