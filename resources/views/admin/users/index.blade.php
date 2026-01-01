<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #f5f5f5;
        }
        form {
            display: inline;
        }
    </style>
</head>
<body>

<h2>Gestion des utilisateurs</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actif</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
                    <select name="role">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="responsable" {{ $user->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </td>

                <td>
                    <select name="active">
                        <option value="1" {{ $user->active ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ !$user->active ? 'selected' : '' }}>Non</option>
                    </select>
                </td>

                <td>
                    <button type="submit">Mettre à jour</button>
                </td>
            </form>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
