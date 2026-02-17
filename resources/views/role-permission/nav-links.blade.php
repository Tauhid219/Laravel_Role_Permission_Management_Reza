<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container mt-3">
    <a href="{{ url('role-permissions') }}" class="btn btn-primary mx-2">Role-Permission Dashboard</a>
    <a href="{{ url('role') }}" class="btn btn-info mx-2">Role</a>
    <a href="{{ url('permission') }}" class="btn btn-info mx-2">Permission</a>
    <a href="{{ url('user') }}" class="btn btn-warning mx-2">User</a>
    <button type="button" class="btn btn-secondary float-end">
        {{ Auth::user()->name }}
    </button>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
