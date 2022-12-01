@extends('layouts.faculty')

@section('content')
    <faculty-my-pds prop-civils='@json($civils)'
        prop-citizenships='@json($citizenships)'
        prop-data='@json($user)'>
    </faculty-my-pds>
@endsection
