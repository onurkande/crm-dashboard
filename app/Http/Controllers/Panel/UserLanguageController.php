<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLanguageController extends Controller
{
    /**
     * Store a newly created user language.
     */
    public function store(Request $request)
    {
        $request->validate([
            'language_code' => 'required|string|max:10',
            'language_name' => 'required|string|max:100'
        ]);

        $languageCode = strtolower(trim($request->language_code));
        $languageName = trim($request->language_name);

        // Check if language is in default languages list first
        $defaultLanguages = UserLanguage::getDefaultLanguages();
        $isDefaultLanguage = false;
        foreach ($defaultLanguages as $language) {
            if ($language['code'] === $languageCode) {
                $isDefaultLanguage = true;
                break;
            }
        }

        if ($isDefaultLanguage) {
            return redirect()->back()->with('error', 'This language is already supported by default. You cannot add default languages as custom languages.');
        }

        // Check if language code is valid using our world languages function
        if (!UserLanguage::isValidLanguageCode($languageCode)) {
            return redirect()->back()->with('error', 'Invalid language code. Please enter a valid ISO language code.');
        }

        // Check if user already has this language
        $existingLanguage = UserLanguage::where('user_id', Auth::id())
            ->where('language_code', $languageCode)
            ->first();

        if ($existingLanguage) {
            return redirect()->back()->with('error', 'This language is already added to your list.');
        }

        // Create new user language
        $userLanguage = UserLanguage::create([
            'user_id' => Auth::id(),
            'language_code' => $languageCode,
            'language_name' => $languageName
        ]);

        return redirect()->back()->with('success', 'Language added successfully.');
    }

    /**
     * Get all languages for the authenticated user.
     */
    public function index()
    {
        $userLanguages = UserLanguage::where('user_id', Auth::id())
            ->orderBy('language_name', 'asc')
            ->get();

        return view('panel.user-languages.index', compact('userLanguages'));
    }

    /**
     * Remove a user language.
     */
    public function destroy($id)
    {
        $userLanguage = UserLanguage::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$userLanguage) {
            return redirect()->back()->with('error', 'Language not found or you do not have permission to delete it.');
        }

        $userLanguage->delete();

        return redirect()->back()->with('success', 'Language removed successfully.');
    }
}
