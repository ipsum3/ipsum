@extends('layouts.website')
@section('title', e($article->tagTitle))
@section('description', e($article->tagMetaDescription))

@section('content')

    <main id="main">
        <header id="header-page" >
            <div class="container">
                <h1 class="title">{{ $article->titre }}</h1>
                @if ($article->extrait)
                    <div class="wysiwyg-wp mt-20"><p>{!! $article->extrait !!}</p></div>
                @endif
            </div><!-- /.container -->
        </header><!-- /#header-page -->
        <div class="container">
            <div class="row pv-75 pv-50-sm pv-30-xs">
                <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                    <div class="row">
                        <div class="col-md-8">
                            <figure class="map-wrapper size-b" data-aos="fade-left">
                                <div id="gmap-simple" class="map-canvas"></div>
                                <figcaption class="figcaption" data-aos="zoom-in-right">
                                    <ul class="list">
                                        <li class="item"><i class="material-icons icon">place</i>{{ config('settings.adresse') }}<br/> {{ config('settings.cp') }} - {{ config('settings.ville') }}</li>
                                        <li class="item"><i class="material-icons icon">phone_iphone</i><a href="tel:{{ config('settings.telephone') }}">{{ config('settings.telephone') }}</a></li>
                                        {{--<li class="item"><i class="material-icons icon">email</i><a href="#"></a></li>--}}
                                        <li class="item"><i class="material-icons icon">schedule</i>{!! nl2br(e(config('settings.horaires'))) !!}</li>
                                    </ul>
                                </figcaption><!-- .figcaption -->
                            </figure> <!-- #map_wrapper -->
                        </div><!-- /.col-sm-8 -->
                    </div><!-- /.row -->
                </div><!-- /.col-8 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
        <section class="bg-gy-d pv-75 pv-50-sm pv-30-xs" data-aos="fade-up">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <h2 class="h-like-a c-or-a text-center">&Eacute;crivez-nous</h2>
                        @include('partials.alert')
                        <form action="{{ route('contact.send') }}" method="post" class="parsley-validate mt-40 mt-15-xs" data-parsley-validate novalidate>
                            @csrf
                            <ul>
                                <li class="row">
                                    <div class="col-sm-6">
                                        <div class="input-wp">
                                            <label class="label-form" for="nom">Nom</label>
                                            <input type="text" class="form-control-bis" required name="nom" value="{{{ request()->old('nom') }}}" id="nom" placeholder="Saisissez votre nom">
                                        </div><!-- .input-wp -->
                                    </div><!-- .col-md-6 -->
                                    <div class="col-sm-6 mt-15-xs">
                                        <div class="input-wp">
                                            <label class="label-form" for="prenom">Prénom</label>
                                            <input type="text" class="form-control-bis" required name="prenom" value="{{{ request()->old('prenom') }}}" id="prenom" placeholder="Saisissez votre prénom">
                                        </div><!-- .input-wp -->
                                    </div><!-- .col-md-6 -->
                                </li><!-- .row -->
                                <li class="row mt-20 mt-0-xs">
                                    <div class="col-sm-6 mt-15-xs">
                                        <div class="input-wp">
                                            <label class="label-form" for="email">Email</label>
                                            <input type="text" class="form-control-bis" required name="email" value="{{{ request()->old('email') }}}" id="email" placeholder="Saisissez votre email">
                                        </div><!-- .input-wp -->
                                        <div class="email-error"></div>
                                    </div><!-- .col-md-6 -->
                                    <div class="col-sm-6 mt-15-xs">
                                        <div class="input-wp">
                                            <label class="label-form" for="phone">Téléphone</label>
                                            <input type="text" class="form-control-bis" name="telephone" value="{{{ request()->old('telephone') }}}" id="phone" placeholder="Saisissez votre téléphone">
                                        </div><!-- .input-wp -->
                                    </div><!-- .col-lg-6 -->
                                </li><!-- .row -->
                                <li class="mt-20 mt-15-sm">
                                    <div class="input-wp">
                                        <label class="label-form" for="message">Message</label>
                                        <textarea class="form-control-bis" id="message" rows="5" required name="texte">{{{ request()->old('texte') }}}</textarea>
                                    </div><!-- .input-wp-->
                                </li><!-- .row -->
                            </ul>
                            <div class="text-center mt-30 mt-20-xs">
                                <button class="btn-wp btn-a pink">Envoyer</button>
                            </div>
                        </form>
                    </div><!-- /.col-10 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.bg-gy-a -->
    </main><!-- #main-->

@stop
