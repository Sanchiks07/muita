<x-layout>
    <x-slot:title>
        Edit User
    </x-slot:title>

    <div class="container">
        <h2>Edit {{ $user->username }}</h2>

        <form method="POST" action="{{ route('users.update', $user->api_id) }}">
            @csrf
            @method('PUT')

            <label>Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" required>

            <label>Full name</label>
            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>

            <label>Role</label>
            <select name="role" required>
                <option value="inspector" {{ $user->role === 'inspector' ? 'selected' : '' }}>Inspector</option>
                <option value="analyst" {{ $user->role === 'analyst' ? 'selected' : '' }}>Analyst</option>
                <option value="broker" {{ $user->role === 'broker' ? 'selected' : '' }}>Broker</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

            <label>
                <input type="checkbox" name="active" value="1" {{ $user->active ? 'checked' : '' }}>
                Active
            </label>

            <button type="submit">Save</button>
            <a href="{{ route('dashboard') }}">Cancel</a>
        </form>
    </div>
</x-layout>
