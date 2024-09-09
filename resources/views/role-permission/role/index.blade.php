<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Index</title>
</head>

<body>

    @include('role-permission.nav-links')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Roles
                            @can('create role')
                                <a href="{{ url('role/create') }}" class="btn btn-primary float-end">Add
                                    Role</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <form action="{{ route('rl.destroy', $role->id) }}" method="POST">
                                                @can('update role')
                                                    <a href="{{ route('rl.edit', $role->id) }}"
                                                        class="btn btn-success">Edit</a>
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                @can('delete role')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                @endcan
                                                @can('create role')
                                                    <a href="{{ route('addPermissionToRole', $role->id) }}"
                                                        class="btn btn-warning">Add
                                                        / Edit Role Permission</a>
                                                @endcan
                                                @can('view role')
                                                    <a href="{{ route('rl.show', $role->id) }}"
                                                        class="btn btn-primary">Show</a>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
