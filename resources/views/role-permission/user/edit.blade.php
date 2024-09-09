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
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User
                            <a href="{{ route('user.index') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                                @error('name')
                                    <span class="text-danger">{{ message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" readonly value="{{ $user->email }}"
                                    class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control" />
                                @error('password')
                                    <span class="text-danger">{{ message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Role</label>
                                <select name="role[]" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach ($role as $role)
                                        <option value="{{ $role->id }}"
                                            {{ in_array($role->id, $userRole) ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ message }}</span>
                                @enderror
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
