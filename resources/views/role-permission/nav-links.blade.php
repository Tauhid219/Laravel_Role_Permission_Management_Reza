<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container mt-3">
    <a href="{{ url('role') }}" class="btn btn-warning mx-2">Role</a>
    <a href="{{ url('permission') }}" class="btn btn-warning mx-2">Permission</a>
    <a href="{{ url('user') }}" class="btn btn-warning mx-2">User</a>
    <a href="{{ url('product') }}" class="btn btn-primary mx-2">Product</a>
    <button type="button" class="dropdown-toggle btn btn-secondary float-end" data-bs-toggle="dropdown"
        aria-expanded="false">
        {{ Auth::user()->name }}
    </button>
    <div class="dropdown-menu">
        <div class="dropdown-item">Role: {{ Auth::user()->getRoleNames()->first() }}</div>
        <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </div>
    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
