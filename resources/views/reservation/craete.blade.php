@extends('layouts.app')

@section('content')
<h1 style="text-align:center;">Créer une réservation</h1>

@if($errors->any())
    <div style="background:#f8d7da;color:#721c24;padding:10px;margin-bottom:10px;border-radius:5px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reservations.store') }}" method="POST" style="max-width:500px;margin:auto;">
    @csrf
    <label for="resource_id">Ressource:</label>
    <select name="resource_id" id="resource_id" style="width:100%;padding:8px;margin-bottom:10px;">
        @foreach($resources as $r)
            <option value="{{ $r->id }}">{{ $r->nom }}</option>
        @endforeach
    </select>

    <label for="date_debut">Date début:</label>
    <input type="datetime-local" name="date_debut" id="date_debut" required style="width:100%;padding:8px;margin-bottom:10px;">

    <label for="date_fin">Date fin:</label>
    <input type="datetime-local" name="date_fin" id="date_fin" required style="width:100%;padding:8px;margin-bottom:10px;">

    <label for="justification">Justification:</label>
    <textarea name="justification" id="justification" required style="width:100%;padding:8px;margin-bottom:10px;" rows="4"></textarea>

    <button type="submit" style="background:#007bff;color:white;padding:10px 20px;border:none;border-radius:5px;">
        Réserver
    </button>
</form>
@endsection
