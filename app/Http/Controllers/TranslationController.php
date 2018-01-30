<?php

namespace App\Http\Controllers;

use Kutip\Translation\Contracts\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\QuoteTranslation;

class TranslationController extends Controller
{
    /**
     * Translation dependency injection.
     *
     * @var Translation
     */
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function translate(Request $request): JsonResponse
    {
        $this->validate($request, [
            'quote_id' => 'required|exists:quotes,id',
            'source' => 'required',
            'destination' => 'required',
            'text' => 'required|string',
        ]);

        $quoteTranslation = QuoteTranslation::where('quote_id', $request->quote_id)
            ->with('quote')
            ->where('source_lang', $request->source)
            ->where('destination_lang', $request->destination)
            ->take(1)
            ->first();

        if (!empty($quoteTranslation)) {
            return response()->json([
                'text' => $quoteTranslation->quote->text,
                'translated_text' => $quoteTranslation->text,
            ]);
        }

        $trans = $this->translation->source($request->source)
            ->destination($request->destination)
            ->translate($request->text);

        if (!empty($trans)) {
            $translations = QuoteTranslation::create([
                'quote_id' => $request->quote_id,
                'source_lang' => $request->source,
                'destination_lang' => $request->destination,
                'text' => $trans,
            ]);
        }

        return response()->json([
            'text' => $request->text,
            'translated_text' => $trans,
        ]);
    }
}
