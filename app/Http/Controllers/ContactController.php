<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContact;
use App\Mail\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Ipsum\Article\app\Models\Article;
use Prologue\Alerts\Facades\Alert;

class ContactController extends Controller
{
    public function index()
    {
        $article = Article::where('nom', 'Contact')->firstOrFail();

        session(['not_spammeur_time' => Carbon::now()]);

        return view('contact.index', compact('article'));
    }

    public function send(SendContact $request)
    {
        Mail::send(new Contact($request));

        Alert::success('Votre demande de contact a bien été envoyée')->flash();

        return redirect()->route('contact.success');
    }
}
