<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.destinations.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_data' => 'required|string',
            'import_type' => 'required|in:json,csv,coordinates',
        ]);

        $importData = $request->import_data;
        $importType = $request->import_type;
        $imported = 0;
        $errors = [];

        try {
            if ($importType === 'json') {
                $data = json_decode($importData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return back()->withErrors(['import_data' => 'Invalid JSON format']);
                }

                foreach ($data as $item) {
                    try {
                        Destination::create([
                            'name' => $item['name'] ?? 'Unnamed Destination',
                            'description' => $item['description'] ?? null,
                            'latitude' => $item['latitude'],
                            'longitude' => $item['longitude'],
                            'address' => $item['address'] ?? null,
                            'city' => $item['city'] ?? null,
                            'state' => $item['state'] ?? null,
                            'order' => $item['order'] ?? 0,
                            'is_active' => $item['is_active'] ?? true,
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Error importing {$item['name'] ?? 'item'}: " . $e->getMessage();
                    }
                }
            } elseif ($importType === 'csv') {
                $lines = explode("\n", $importData);
                $headers = str_getcsv(array_shift($lines));
                
                foreach ($lines as $line) {
                    if (empty(trim($line))) continue;
                    $data = str_getcsv($line);
                    if (count($data) < 3) continue;
                    
                    try {
                        Destination::create([
                            'name' => $data[0] ?? 'Unnamed Destination',
                            'latitude' => floatval($data[1] ?? 0),
                            'longitude' => floatval($data[2] ?? 0),
                            'address' => $data[3] ?? null,
                            'city' => $data[4] ?? null,
                            'state' => $data[5] ?? null,
                            'order' => intval($data[6] ?? 0),
                            'is_active' => isset($data[7]) ? (bool)$data[7] : true,
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Error importing line: " . $e->getMessage();
                    }
                }
            } elseif ($importType === 'coordinates') {
                // Format: Name,Latitude,Longitude,Address,City,State
                $lines = explode("\n", $importData);
                
                foreach ($lines as $line) {
                    if (empty(trim($line))) continue;
                    
                    // Try to parse different formats
                    if (preg_match('/(.+?),\s*([-+]?\d+\.?\d*),\s*([-+]?\d+\.?\d*)(?:,\s*(.+?))?(?:,\s*(.+?))?(?:,\s*(.+?))?/', $line, $matches)) {
                        try {
                            Destination::create([
                                'name' => trim($matches[1]),
                                'latitude' => floatval($matches[2]),
                                'longitude' => floatval($matches[3]),
                                'address' => isset($matches[4]) ? trim($matches[4]) : null,
                                'city' => isset($matches[5]) ? trim($matches[5]) : null,
                                'state' => isset($matches[6]) ? trim($matches[6]) : null,
                                'order' => 0,
                                'is_active' => true,
                            ]);
                            $imported++;
                        } catch (\Exception $e) {
                            $errors[] = "Error importing line: " . $e->getMessage();
                        }
                    }
                }
            }

            $message = "Successfully imported {$imported} destination(s).";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " error(s) occurred.";
            }

            return redirect()->route('admin.destinations.index')
                ->with('success', $message)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            return back()->withErrors(['import_data' => 'Import failed: ' . $e->getMessage()]);
        }
    }
}

