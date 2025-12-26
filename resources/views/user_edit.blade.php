<x-layout>
    <x-slot:title>
        Edit User
    </x-slot:title>

    <div class="container">
        <div class="create-container">
            <h2>Edit {{ $user->full_name }} User</h2><br>

            <form method="POST" action="{{ route('users.update', $user->id) }}" class="create-form user">
                @csrf
                @method('PUT')

                <div style="margin-bottom:5px;">
                    <label for="api_id">User ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "usr-000001"</span>
                    </div>
                </div>
                <input type="text" id="api_id" name="api_id" value="{{ $user->api_id }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="username">Username</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "user1"</span>
                    </div>
                </div>
                <input type="text" id="username" name="username" value="{{ $user->username }}" required><br>

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