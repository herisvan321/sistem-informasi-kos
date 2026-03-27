<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ModerationService;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $reports = Report::with(['reporter', 'listing'])
            ->when($search, function($query, $search) {
                $query->where('type', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($type, function($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate(10);
        return view('admin.moderation.index', compact('reports'));
    }

    public function resolve(Report $report)
    {
        $this->moderationService->resolve($report->id);
        return back()->with('success', 'Laporan berhasil diselesaikan!');
    }

    public function destroy(Report $report)
    {
        // For deleting associated listing if necessary, or just the report
        if ($report->listing_id) {
            $report->listing->delete();
        }
        $report->delete();
        return back()->with('success', 'Konten dan laporan berhasil dihapus!');
    }
}
