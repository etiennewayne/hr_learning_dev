@extends('layouts.faculty')

@section('content')
    <faculty-pds prop-civils='@json($civils)'
        prop-citizenships='@json($citizenships)'>
    </faculty-pds>
@endsection
