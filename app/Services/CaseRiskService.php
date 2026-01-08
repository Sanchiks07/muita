<?php

namespace App\Services;

use App\Models\Cases;
use App\Models\Vehicles;
use App\Models\Documents;
use App\Models\Inspections;
use Carbon\Carbon;

class CaseRiskService
{
    /**
     * @param \stdClass|Cases
     * @return array
     */
    public function computeForCase($case): array
    {
        $score = 0;
        $details = [];

        // ---------- 1. Existing risk flags (+1 point) ----------
        $flagsCount = 0;
        if (!empty($case->risk_flags)) {
            $decoded = json_decode($case->risk_flags, true);
            if (is_array($decoded)) {
                $flagsCount = count(array_filter($decoded));
            } else {
                $parts = array_filter(array_map('trim', explode(',', $case->risk_flags)));
                $flagsCount = count($parts);
            }
        }

        if ($flagsCount > 0) {
            $score += 1;
            $details[] = "Existing risk flags present ({$flagsCount}) => +1";
        }

        // ---------- 2. No documents uploaded (+1 point) ----------
        $docCount = Documents::where('case_id', $case->api_id)->count();
        if ($docCount === 0) {
            $score += 1;
            $details[] = "No documents uploaded => +1";
        }

        // ---------- 3. Vehicle not found (+1 point) ----------
        $vehicle = Vehicles::where('api_id', $case->vehicle_id)->first();
        if (!$vehicle) {
            $score += 1;
            $details[] = "Vehicle not found => +1";
        } else {
            /* -------------------------------------------------
             * 4. Vehicle country differs from origin (+1 point)
             * ------------------------------------------------- */
            if (
                !empty($vehicle->country) &&
                !empty($case->origin_country) &&
                strtolower($vehicle->country) !== strtolower($case->origin_country)
            ) {
                $score += 1;
                $details[] = "Vehicle country differs from origin => +1";
            }
        }

        // ---------- 5. Night arrival (00:00–04:59) (+1 point) ----------
        if (!empty($case->arrival_ts)) {
            try {
                $dt = Carbon::parse($case->arrival_ts);
                $hour = (int) $dt->format('G');
                if ($hour >= 0 && $hour <= 4) {
                    $score += 1;
                    $details[] = "Night arrival (hour {$hour}) => +1";
                }
            } catch (\Exception $e) {
                // ignore parse errors
            }
        }

        // ---------- 6. Risky status (binary) (+1 point) ----------
        $status = strtolower($case->status ?? '');
        if (in_array($status, ['new', 'screening', 'in inspection', 'on hold'], true)) {
            $score += 1;
            $details[] = "Status '{$case->status}' indicates risk => +1";
        }

        // ---------- 7. Historical origin risk (binary) (+1 point) ----------
        if (!empty($case->origin_country)) {
            $totalFromOrigin = Cases::where('origin_country', $case->origin_country)->count();
            if ($totalFromOrigin > 10) {
                $flagged = Cases::where('origin_country', $case->origin_country)
                    ->whereNotNull('risk_flags')
                    ->where('risk_flags', '<>', '')
                    ->count();

                $ratio = $flagged / max(1, $totalFromOrigin);
                if ($ratio > 0.2) {
                    $score += 1;
                    $details[] = "Historical risk from origin ({$case->origin_country}, ratio {$ratio}) => +1";
                }
            }
        }

        return [
            'score' => $score,
            'details' => $details,
        ];
    }

    // Scans all cases and generates auto inspections
    // Returns an array of results
    public function scanAll(int $threshold = 30, ?string $assignedTo = null): array
    {
        $results = [];
        $cases = Cases::all();

        foreach ($cases as $case) {
            $res = $this->computeForCase($case);

            $createdInspection = false;
            if ($res['score'] >= $threshold) {
                $exists = Inspections::where('case_id', $case->api_id)
                    ->where('type', 'auto')
                    ->count();

                if ($exists === 0) {
                    Inspections::create([
                        'api_id' => 'auto-' . uniqid(),
                        'case_id' => $case->api_id,
                        'type' => 'auto',
                        'requested_by' => 'system',
                        'start_ts' => Carbon::now()->toDateTimeString(),
                        'location' => $case->checkpoint_id ?? '',
                        'checks' => json_encode($res['details']),
                        'assigned_to' => $assignedTo ?? (auth()->check() ? auth()->user()->username : null),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    $createdInspection = true;
                }
            }

            $results[] = [
                'case_id' => $case->api_id,
                'score' => $res['score'],
                'threshold' => $threshold,
                'inspection_created' => $createdInspection,
                'details' => $res['details'],
            ];
        }

        return $results;
    }
}
