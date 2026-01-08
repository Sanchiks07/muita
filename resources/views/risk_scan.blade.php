<x-layout>
    <x-slot:title>
        Risk Scan
    </x-slot:title>

    <div class="container">
        <?php $last = $riskScanResults ?? $lastRiskScan ?? null; ?>

        <div class="risk-container">
            @if($last)
                <div class="risk-results">
                    <h3>Risk scan results</h3>

                    <p>Total cases scanned: {{ count($last) }}</p>
                    <?php
                        $created = collect($last)->where('inspection_created', true)->count();
                        $top = collect($last)
                            ->sortByDesc('score')
                            ->take(50)
                            ->values();
                    ?>
                    <p>Auto inspections created: {{ $created }}</p>

                    <h3 style="margin-top:10px;">Top 50 risky cases</h3>
                    <div class="top-risk-columns">
                        <ul>
                            @foreach($top->slice(0, 25) as $t)
                                <li>{{ $t['case_id'] }} - score: {{ $t['score'] }}</li>
                            @endforeach
                        </ul>

                        <ul>
                            @foreach($top->slice(25, 25) as $t)
                                <li>{{ $t['case_id'] }} - score: {{ $t['score'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="risk-results">
                    <p>No risk scan results available. Run a scan to create results.</p>
                </div>
            @endif
            
            <div>
                <div class="risk-legend">
                    <h3 style="margin-bottom:8px;">Risk score legend</h3>

                    <ul>
                        <li>
                            <strong>Risk flags:</strong> if any risk flags exist (one or more) → +1 point
                        </li>
                        <li>
                            <strong>No documents uploaded:</strong> +1 point
                        </li>
                        <li>
                            <strong>Vehicle not found:</strong> +1 point
                        </li>
                        <li>
                            <strong>Vehicle country differs from origin:</strong> +1 point
                        </li>
                        <li>
                            <strong>Night arrival (00:00-04:59):</strong> +1 point
                        </li>
                        <li>
                            <strong>Status:</strong> new / screening / in inspection / on hold → +1 point
                        </li>
                        <li>
                            <strong>Historical origin risk:</strong> if >20% of past cases from the same origin had risk flags → +1 point
                        </li>
                    </ul>
                </div>

                @if(auth()->check() && in_array(auth()->user()->role, ['admin','inspector','analyst']))
                    <div style="grid-column:2/3; justify-self:center; align-self:center; margin-top:50px;">
                        <a href="{{ route('risk.scan') }}?run_risk_scan=1" class="risk-scan-btn">Run risk scan</a>
                    </div>
            @endif
            </div>
        </div>
    </div>
</x-layout>