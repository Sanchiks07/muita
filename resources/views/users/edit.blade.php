<x-layout>
    <x-slot:title>
        Edit User
    </x-slot:title>

    <div class="container">
        <!-- error messages -->
        @if ($errors->any())
            <div class="error-messages">
                <ul style="margin:0; padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- the user edit form -->
        <div class="create-container">
            <h2>Edit {{ $user->full_name }} User</h2><br>

            <form method="POST" action="{{ route('users.update', $user->id) }}" class="create-form user">
                @csrf
                @method('PUT')

                <label for="api_id">User ID</label>
                <input type="text" id="api_id" name="api_id" value="{{ $user->api_id }}" style="color:#ccc;" disabled><br>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ $user->username }}" style="color:#ccc;" disabled><br>

                <label for="full_name">Full name</label>
                <input type="text" id="full_name" name="full_name" value="{{ $user->full_name }}" required><br>

                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select a role</option>
                    <option value="inspector" {{ $user->role === 'inspector' ? 'selected' : '' }}>Inspector</option>
                    <option value="analyst" {{ $user->role === 'analyst' ? 'selected' : '' }}>Analyst</option>
                    <option value="broker" {{ $user->role === 'broker' ? 'selected' : '' }}>Broker</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select><br>

                <label for="active" class="checkbox">
                    <input type="checkbox" id="active" name="active" value="1" {{ $user->active ? 'checked' : '' }}>
                    Active
                </label>
                <br><br>

                <div class="actions">
                    <button type="submit" class="save-btn">Save</button>
                    <a href="{{ route('dashboard') }}" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>