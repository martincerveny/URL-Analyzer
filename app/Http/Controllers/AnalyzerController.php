<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\AnalyzerRequest;
use App\Http\ResponseFactory;
use App\Services\Web\AnalyzerService;
use Illuminate\Http\JsonResponse;


class AnalyzerController extends Controller
{

    /**
     * @var AnalyzerService
     */
    private $analyzerService;

    /**
     * AnalyzerController constructor.
     * @param AnalyzerService $analyzerService
     */
    public function __construct(AnalyzerService $analyzerService)
    {
        $this->analyzerService = $analyzerService;
    }

    public function intro()
    {
        return view('analyzer');
    }

    public function analyze(AnalyzerRequest $request)
    {
        $analysis = $this->analyzerService->analyze($request);

        if (empty($analysis)) {
            return back()->withErrors([__('content.something_went_wrong')]);
        } else {
            return view('analyzer', [
                'result' => $analysis
            ]);
        }

    }

    public function analyzeJson(AnalyzerRequest $request): JsonResponse
    {
        return ResponseFactory::createSuccessfulResponse($this->analyzerService->analyze($request));
    }

}



