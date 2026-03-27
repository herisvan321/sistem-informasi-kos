<?php

namespace App\Services;

use App\Models\Report;

class ModerationService extends BaseService
{
    public function __construct(Report $report)
    {
        parent::__construct($report);
    }

    public function resolve(string $id): bool
    {
        return $this->update($id, ['status' => 'Resolved']);
    }

    public function handleReport(string $id, string $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }
}