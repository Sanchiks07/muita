<x-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="container">
        @switch(auth()->user()->role)
            @case('inspector')
                <div>inspector nam nam</div>
                @break

            @case('analyst')
                <div>analyst nam nam</div>
                @break

            @case('broker')
                <div>broker nam nam</div>
                @break

            @case('admin')
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->active ? 'True' : 'False' }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->api_id) }}">Edit</a>
                                    <form method="POST" action="{{ route('users.destroy', $user->api_id) }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(method_exists($users, 'links'))
                    <div class="pagination">
                        {{ $users->links() }}
                    </div>
                @endif
                @break

            @default
                <p>Nothing to see here.</p>
        @endswitch
    </div>
</x-layout>