<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ErpSyncRequest;
use App\Http\Resources\ErpSyncResource;
use App\Services\ErpIntegration\ErpIntegrationService;
use App\Models\ErpSyncLog;
use App\Jobs\SyncEmployeesFromErp;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ErpController extends Controller
{
    protected $erpIntegrationService;

    public function __construct(ErpIntegrationService $erpIntegrationService)
    {
        $this->erpIntegrationService = $erpIntegrationService;
    }

    /**
     * Sync employees from ERP system
     */
    public function syncEmployees(ErpSyncRequest $request): JsonResponse
    {
        try {
            $erpType = $request->input('erp_type'); // sap, oracle, dynamics
            $tenantId = $request->input('tenant_id');
            $syncMode = $request->input('sync_mode', 'incremental'); // full, incremental

            // Dispatch background job for large syncs
            $job = SyncEmployeesFromErp::dispatch($erpType, $tenantId, $syncMode);

            // Create sync log entry
            $syncLog = ErpSyncLog::create([
                'tenant_id' => $tenantId,
                'erp_type' => $erpType,
                'sync_mode' => $syncMode,
                'status' => 'initiated',
                'job_id' => $job->getJobId(),
                'started_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee sync initiated successfully',
                'sync_id' => $syncLog->id,
                'job_id' => $job->getJobId(),
            ], 202);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate employee sync',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get sync status
     */
    public function getSyncStatus(Request $request): JsonResponse
    {
        $syncId = $request->input('sync_id');
        $tenantId = $request->input('tenant_id');

        $syncLog = ErpSyncLog::where('id', $syncId)
            ->where('tenant_id', $tenantId)
            ->first();

        if (!$syncLog) {
            return response()->json([
                'success' => false,
                'message' => 'Sync record not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ErpSyncResource($syncLog),
        ]);
    }

    /**
     * Configure field mapping for ERP integration
     */
    public function configureMapping(Request $request): JsonResponse
    {
        $request->validate([
            'erp_type' => 'required|in:sap,oracle,dynamics',
            'tenant_id' => 'required|string',
            'field_mappings' => 'required|array',
        ]);

        try {
            $result = $this->erpIntegrationService->configureFieldMapping(
                $request->input('erp_type'),
                $request->input('tenant_id'),
                $request->input('field_mappings')
            );

            return response()->json([
                'success' => true,
                'message' => 'Field mapping configured successfully',
                'data' => $result,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to configure field mapping',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test ERP connection
     */
    public function testConnection(Request $request): JsonResponse
    {
        $request->validate([
            'erp_type' => 'required|in:sap,oracle,dynamics',
            'tenant_id' => 'required|string',
        ]);

        try {
            $result = $this->erpIntegrationService->testConnection(
                $request->input('erp_type'),
                $request->input('tenant_id')
            );

            return response()->json([
                'success' => true,
                'message' => 'Connection test successful',
                'data' => $result,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}