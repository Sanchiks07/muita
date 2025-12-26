<x-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="container">
        @switch(auth()->user()->role)
            @case('inspector')
                <h1>List of Cases</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Case ID</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Checkpoint ID</th>
                            <th>Orign → Destination</th>
                            <th>Declarant ID</th>
                            <th>Consignee ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            <tr>
                                <td>{{ $case->api_id }}</td>
                                <td>{{ $case->status }}</td>
                                <td>{{ $case->priority }}</td>
                                <td>{{ $case->checkpoint_id }}</td>
                                <td>{{ $case->origin_country }} → {{ $case->destination_country }}</td>
                                <td>{{ $case->declarant_id }}</td>
                                <td>{{ $case->consignee_id }}</td>
                                <td><a href="{{ route('cases.show', $case->api_id) }}" class="view-btn">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $cases->links() }}
                </div>
                @break

            @case('analyst')
                <h1>List of Cases</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Case ID</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Checkpoint ID</th>
                            <th>Orign → Destination</th>
                            <th>Risk Flags</th>
                            <th>Declarant ID</th>
                            <th>Consignee ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            <tr>
                                <td>{{ $case->api_id }}</td>
                                <td>{{ $case->status }}</td>
                                <td>{{ $case->priority }}</td>
                                <td>{{ $case->checkpoint_id }}</td>
                                <td>{{ $case->origin_country }} → {{ $case->destination_country }}</td>
                                <td>
                                    <?php
                                        $flags = json_decode($case->risk_flags, true); // decode as array
                                    ?>

                                    @if ($flags && array_filter($flags)) <!-- array_filter removes empty strings -->
                                        @foreach($flags as $flag)
                                            <span style="display:block; margin-bottom:2px;">{{ $flag }}</span>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $case->declarant_id }}</td>
                                <td>{{ $case->consignee_id }}</td>
                                <td><a href="{{ route('cases.show', $case->api_id) }}" class="view-btn">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $cases->links() }}
                </div>
                @break

            @case('broker')
                <h1>List of Documents</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Document ID</th>
                            <th>Case ID</th>
                            <th>Filename</th>
                            <th>MIME Type</th>
                            <th>Category</th>
                            <th>Pages</th>
                            <th>Uploaded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td>{{ $document->api_id }}</td>
                                <td>{{ $document->case_id }}</td>
                                <td>{{ $document->filename }}</td>
                                <td>{{ $document->mime_type }}</td>
                                <td>{{ $document->category }}</td>
                                <td>{{ $document->pages }}</td>
                                <td>{{ $document->uploaded_by }}</td>
                                <td>
                                    <a href="{{ route('documents.edit', $document->api_id) }}" class="edit-btn">Edit</a>
                                    <form method="POST" action="{{ route('documents.destroy', $document->api_id) }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return confirm('Delete this document?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $documents->links() }}
                </div>
                @break

            @case('admin')
                <h1>List of Users</h1>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
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
                                <td>{{ $user->api_id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->active ? 'True' : 'False' }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->api_id) }}" class="edit-btn">Edit</a>
                                    <form method="POST" action="{{ route('users.destroy', $user->api_id) }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $users->links() }}
                </div>
                @break

            @default
                <p>Nothing to see here.</p>
        @endswitch
    </div>
</x-layout>