<x-layout>
    <x-slot:title>
        Inspections
    </x-slot:title>

    <div class="container">
        <h1>List of Inspections</h1>
        <table>
            <thead>
                <tr>
                    <th>Inspection ID</th>
                    <th>Case ID</th>
                    <th>Type</th>
                    <th>Requested By</th>
                    <th>Start Time</th>
                    <th>Location</th>
                    <th>Checks</th>
                    <th>Assigned To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->api_id }}</td>
                        <td>{{ $inspection->case_id }}</td>
                        <td>{{ $inspection->type }}</td>
                        <td>{{ $inspection->requested_by }}</td>
                        <?php
                                if (!empty($inspection->start_ts) && strtotime($inspection->start_ts)) {
                                    $start = date('Y-m-d H:i', strtotime($inspection->start_ts));
                                } elseif (!empty($inspection->start_ts)) {
                                    // parāda raw value ja parsing fails
                                    $start = $inspection->start_ts;
                                } else {
                                    $start = 'N/A';
                                }
                            ?>
                            <td>{{ $start }}</td>
                        <td>{{ $inspection->location }}</td>
                        <td>
                            <?php
                                $checks = json_decode($inspection->checks, true);
                            ?>

                            @if (is_array($checks) && count($checks))
                                @foreach ($checks as $check)
                                    <span style="display:block; margin-bottom:2px;">
                                        {{ $check['name'] ?? 'Unknown check' }} - {{ ucfirst($check['result'] ?? 'n/a') }}
                                    </span>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $inspection->assigned_to }}</td>
                        <td style="text-align:center">
                            <a href="{{ route('inspections.show', $inspection->api_id) }}" class="view-btn">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $inspections->links() }}
        </div>
    </div>
</x-layout>