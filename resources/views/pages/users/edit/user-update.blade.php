@extends('layouts.master')

@php

@endphp

@section('content')
    <div class="container-fluid p-4">

        @include('pages.users.edit.user-basic-update')

        @include('pages.users.edit.user-change-password')
    </div>
@endsection
