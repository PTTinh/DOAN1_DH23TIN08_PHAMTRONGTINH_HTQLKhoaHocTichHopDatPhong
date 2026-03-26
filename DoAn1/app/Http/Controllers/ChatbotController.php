<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(private readonly ChatbotService $chatbotService)
    {
        
    }

    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $result = $this->chatbotService->chat($validated['message'], $request);

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    public function history(Request $request): JsonResponse
    {
        return response()->json($this->chatbotService->getHistory($request));
    }

    public function clear(Request $request): JsonResponse
    {
        return response()->json($this->chatbotService->clearHistory($request));
    }
}
