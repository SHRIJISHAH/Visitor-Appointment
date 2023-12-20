
    <h2>Delete User</h2>

    <p>Are you sure you want to delete the user "{{ $user->name }}"?</p>

    <form method="POST" action="{{ route('admin.confirm-delete-user', ['id' => $user->id]) }}">
        @csrf
        <button type="submit">Yes, delete user</button>
    </form>

    <a href="{{ route('admin.show-all-users') }}">Cancel</a>

