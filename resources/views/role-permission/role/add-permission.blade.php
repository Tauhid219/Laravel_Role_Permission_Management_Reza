<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Role: {{ $role->name }}
                            <a href="{{ url('role') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('givePermissionToRole', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                @error('permission')
                                    <span class="text-danger">{{ message }}</span>
                                @enderror
                                <label for="">Permissions</label>
                                <div class="row">
                                    @foreach ($permission as $permission)
                                        <div class="col-md-2">
                                            <label for="">
                                                <input type="checkbox" name="permission[]"
                                                    value="{{ $permission->name }}"
                                                    {{ in_array($permission->id, $rolepermission) ? 'checked' : '' }}>
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
