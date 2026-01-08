<x-layout>
    <x:slot:title>
        {{ $inspection->api_id }} View
    </x:slot:title>

    <div class="container">
        <!-- inspection details -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; margin-bottom:40px;">
            <h2>{{ $inspection->api_id }} Details</h2><br>

            <table>
                <thead>
                    <tr>
                        <th>Inspection ID</th>
                        <th>Case ID</th>
                        <th>Requested By</th>
                        <th>Start Time</th>
                        <th>Location</th>
                        <th>Checks</th>
                        <th>Assigned To</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $inspection->api_id }}</td>
                        <td>{{ $inspection->case_id }}</td>
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
                    </tr>
                </tbody>
            </table>

            <br><br>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('inspections.edit', $inspection->api_id) }}" class="edit-btn">Edit</a>
                <form method="POST" action="{{ route('inspections.destroy', $inspection->api_id) }}" style="display:inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this inspection?');">Delete</button>
                </form>
                <a href="{{ route('inspections') }}" class="back-btn">Back to Inspections</a>
            </div>
        </div>

        <!-- decision -->
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
            <h2>Inspection Type: {{ $inspection->type }}</h2><br>

            <form method="POST" action="{{ route('inspections.updateDecision', $inspection->api_id) }}" class="create-form inspection">
                @csrf
                @method('PUT')

                <label for="decision">Decision</label>
                <select name="decision" id="decision">
                    <option value="" disabled {{ $inspection->decision === '' ? 'selected' : '' }}>Select your decision</option>
                    <option value="release" {{ $inspection->decision === 'release' ? 'selected' : '' }}>Release</option>
                    <option value="hold" {{ $inspection->decision === 'hold' ? 'selected' : '' }}>Hold</option>
                    <option value="reject" {{ $inspection->decision === 'reject' ? 'selected' : '' }}>Reject</option>
                </select><br>

                <div style="margin-bottom:5px;">
                    <label for="explanation">Explanation</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">Why are you making this decision?</span>
                    </div>
                </div>
                <textarea name="explanation" id="explanation">{{ $inspection->explanation }}</textarea><br><br>

                <button type="submit" class="save-btn">Submit Decision</button>
            </form>
        </div>
    </div>
</x-layout>