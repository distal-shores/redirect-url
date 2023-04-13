<?php

namespace App\Http\Controllers;

use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RedirectController extends Controller
{
    public function index()
    {
        // Get all the redirects from the database
        $redirects = DB::table('redirects')->get();
        
        // Return a view with the list of redirects
        return view('redirects.index', ['redirects' => $redirects]);
    }

    public function followRedirect(Request $request)
    {
        // Define (example) GA tracking params. In a more fleshed out app, these would live perhaps in the database, or perhaps would be pulled directly from the GA API, and there would be an interface for modifying them.
        define("GA_PARAMS", "?utm_source=shortener&utm_medium=link&utm_campaign=redirects");

        // Get the requested URL
        $url = $request->url;
        
        // Check if there's a redirect for this URL in the database
        $redirect = DB::table('redirects')->where('target_url', $url)->first();

        // Append GA tracking params
        $urlWithTracking = $redirect->source_url . GA_PARAMS;
        
        // If there's a redirect, redirect the user to the target URL
        if($redirect) {
            return redirect($urlWithTracking);
        } else {
            // In a more fleshed out app, would handle this error more gracefully with a message to the user
            abort(404);
        }
    
    }

    public function createRedirect(Request $request)
    {
        $url = $request->input('url');
        $redirect = DB::table('redirects')->where('source_url', $url)->first();
        
        if ($redirect) {
            // In a more fleshed out app, would add a user message here to indicate that the redirect already exists
            return redirect('/');
        } else {
            $newRedirect = new Redirect;
            $newRedirect->source_url = $url;
            $newRedirect->target_url = Str::random(5);
            $newRedirect->save();
    
            // In a more fleshed out app, would add a user message here to indicate that the redirect was created
            return redirect('/');
        }
    }
}