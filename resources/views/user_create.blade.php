<x-layout>
    <x-slot:title>
        Add New User
    </x-slot:title>

    <div class="container">
        <div class="create-container">
            <h2>Add New User</h2><br>

            <form method="POST" action="{{ route('users.store') }}" class="create-form user">
                @csrf

                <div style="margin-bottom:5px;">
                    <label for="api_id">User ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "usr-000001"</span>
                    </div>
                </div>
                <input type="text" id="api_id" name="api_id" required><br>

                <div style="margin-bottom:5px;">
                    <label for="username">Username</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "user1"</span>
                    </div>
                </div>
                <input type="text" id="username" name="username" required><br>

                <label for="full_name">Full name</label>
                <input type="text" id="full_name" name="full_name" required><br>

                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select a role</option>
                    <option value="inspector">Inspector</option>
                    <option value="analyst">Analyst</option>
                    <option value="broker">Broker</option>
                    <option value="admin">Admin</option>
                </select><br>

                <label for="active" class="checkbox">
                    <input type="checkbox" id="active" name="active" value="1">
                    Active
                </label>
                <br><br>

                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
</x-layout>