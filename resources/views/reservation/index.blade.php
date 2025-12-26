@extends('layouts.app')

@section('content')
<h1 style="text-align:center;">Mes réservations</h1>

@if(session('success'))
    <div style="background:#d4edda;color:#155724;padding:10px;margin-bottom:10px;border-radius:5px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%;border-collapse:collapse;margin-top:20px;">
    <thead>
        <tr style="background:#007bff;color:white;">
            <th style="padding:10px;border:1px solid #ddd;">Ressource</th>
            <th style="padding:10px;border:1px solid #ddd;">Date début</th>
            <th style="padding:10px;border:1px solid #ddd;">Date fin</th>
            <th style="padding:10px;border:1px solid #ddd;">Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $res)
            <tr style="border-bottom:1px solid #ddd;">
                <td style="padding:10px;">{{ $res->resource->nom }}</td>
                <td style="padding:10px;">{{ $res->date_debut }}</td>
                <td style="padding:10px;">{{ $res->date_fin }}</td>
                <td style="padding:10px;">
                    @if($res->statut == 'En attente')
                        <span style="color:orange;">{{ $res->statut }}</span>
                    @elseif($res->statut == 'Approuvée')
                        <span style="color:green;">{{ $res->statut }}</span>
                    @elseif($res->statut == 'Refusée')
                        <span style="color:red;">{{ $res->statut }}</span>
                    @else
                        {{ $res->statut }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:20px;">
    <a href="{{ route('reservations.create') }}" 
       style="background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
       Nouvelle réservation
    </a>
</div>
@endsection
