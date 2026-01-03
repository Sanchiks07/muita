<x-layout>
    <x-slot:title>
        {{ $case->api_id }} View
    </x-slot:title>

    <div class="container">
        <h2>{{ $case->api_id }} Details</h2><br>

        <table>
            <thead>
                <tr>
                    <th>Case ID</th>
                    <th>External Ref</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Arrival</th>
                    <th>Checkpoint ID</th>
                    <th>Orign → Destination</th>
                    <th>Risk Flags</th>
                    <th>Declarant ID</th>
                    <th>Consignee ID</th>
                    <th>Vehicle ID</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $case->api_id }}</td>
                    <td>{{ $case->external_ref }}</td>
                    <td>{{ $case->status }}</td>
                    <td>{{ $case->priority }}</td>
                    <?php
                        if (!empty($case->arrival_ts) && strtotime($case->arrival_ts)) {
                            $arrival = date('Y-m-d H:i', strtotime($case->arrival_ts));
                        } elseif (!empty($case->arrival_ts)) {
                            // parāda raw value ja parsing fails
                            $arrival = $case->arrival_ts;
                        } else {
                            $arrival = 'N/A';
                        }
                    ?>
                    <td>{{ $arrival }}</td>
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
                    <td>{{ $case->vehicle_id }}</td>
                </tr>
            </tbody>
        </table>

        <br><br>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('cases.edit', $case->api_id) }}" class="edit-btn">Edit</a>
            <form method="POST" action="{{ route('cases.destroy', $case->api_id) }}" style="display:inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this case?');">Delete</button>
            </form>
            <a href="{{ route('dashboard') }}" class="back-btn">Back to Dashboard</a>
        </div>
    </div>
</x-layout>