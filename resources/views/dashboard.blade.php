<x-layout>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Case ID</th>
                    <th>External Ref.</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Arrival Time</th>
                    <th>Route</th>
                    <th>Checkpoint ID</th>
                    <th>Risk Flags</th>
                    <th>Declarant</th>
                    <th>Consignee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cases as $case)
                    <tr>
                        <td>{{ $case->api_id}}</td>
                        <td>{{ $case->external_ref}}</td>
                        <td>{{ $case->status}}</td>
                        <td>{{ $case->priority}}</td>
                        <td>{{ $case->arrival_ts}}</td>
                        <td>{{ $case->origin_country}} -> {{ $case->destination_country}}</td>
                        <td>{{ $case->checkpoint_id}}</td> 
                        <td>
                            @php
                                $flags = json_decode($case->risk_flags, true);
                            @endphp

                            @if($flags && array_filter($flags)) <!-- array_filter removes empty strings -->
                                @foreach($flags as $flag)
                                    <span style="display: block; margin-bottom: 5px;">{{ $flag }}</span>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $case->declarant_id}}</td>
                        <td>{{ $case->consignee_id}}</td>
                        <td><a href="/cases/{{ $case->id }}" class="view_link">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>