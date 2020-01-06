@component('mail::message')

Bonjour,

Vous avez reçu un nouveau message en provenance du site [{{{ config('settings.nom_site') }}}]({{{ config('app.url') }}}).

**Nom :** {{{ $contact->nom }}}<br />
**Prénom :** {{{ $contact->prenom }}}<br />
**Email :** {{{ $contact->email }}}<br />
**Téléphone :** {{{ $contact->telephone }}}<br />
**Message :**<br />

{!!  nl2br(e($contact->texte)) !!}

@endcomponent
