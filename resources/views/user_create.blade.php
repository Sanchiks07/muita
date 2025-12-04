<x-layout>
    <x-slot:title>
        Add New User
    </x-slot:title>

    <div class="container">
        <h2>Add New User</h2>

        <form method="POST" action="{{ route('users.store') }}" class="user-form">
            @csrf

            <label for="api_id">User ID</label>
            <input type="text" id="api_id" name="api_id" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="full_name">Full name</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Select a role</option>
                <option value="inspector">Inspector</option>
                <option value="analyst">Analyst</option>
                <option value="broker">Broker</option>
                <option value="admin">Admin</option>
            </select>

            <label>
                Active
                <input type="checkbox" name="active" value="1">
            </label>

            <label for="password">Password</label>
            <div>
                <input type="password" id="password" name="password" required>
                <div class="tooltip">
                    ⓘ
                    <span class="tooltip-text">Password must be 'role'123</span>
                </div>
            </div>

            <button type="submit">Save</button>
        </form>
    </div>
</x-layout>