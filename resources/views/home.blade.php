<h1>hello world!
    <br>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-link p-0 text-decoration-none">
        <i class="fas fa-sign-out-alt me-1"></i> Logout
    </button>
</form>
</h1>