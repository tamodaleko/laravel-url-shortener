<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'redirect']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = new Url;
        $url->user_id = \Auth::user()->id;
        $url->url = $request->input('url');
        $url->clicks = 0;

        do {
            $code = Str::random(8);
        } while (Url::where('code', $code)->count() > 0);

        $url->code = $code;

        if ($url->save()) {
            $request->session()->flash('store-success', 'URL has been shortened successfully!');
        } else {
            $request->session()->flash('store-danger', 'URL could not be shortened!');
        }

        return redirect()->route('home', ['code' => $code]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url = Url::findOrFail($id);

        if ($url->delete()) {
            session()->flash('destroy-success', 'URL has been deleted successfully!');
        } else {
            session()->flash('destroy-danger', 'URL could not be deleted!');
        }

        return redirect()->route('home');
    }

    /**
     * Redirect to url.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function redirect($code)
    {
        $url = Url::where('code', $code)->first();

        if ($url) {
            return redirect($url->url);
        }

        return redirect()->route('home');
    }
}
