 <?php
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ChatController extends Controller
{
   public function chat(Request $request)
{
    try {
        $response = Http::withHeaders([
            'api-key' => env('AZURE_OPENAI_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('AZURE_OPENAI_ENDPOINT') . '/openai/deployments/' . env('AZURE_OPENAI_DEPLOYMENT') . '/chat/completions?api-version=' . env('AZURE_OPENAI_API_VERSION'), [
            'messages' => [
                ['role' => 'user', 'content' => $request->input('message')],
            ],
            'max_tokens' => 200,
        ]);

        return response()->json($response->json());

    } catch (\Exception $e) {
        // TEMP: Mostrar el error exacto
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
