@extends('layouts.website')
@section('title', $article->tagTitle)
@section('description', $article->tagMetaDescription)

@section('content')

    <main id="main">
        <header id="header-page">
            <div class="container">
                <h1 class="title">{{ $article->titre }}</h1>
                @if ($article->categorie)
                <div class="text-center mt-10 mt-0-xs">
                    <a href="{{  route('blog.category', $article->categorie->slug) }}" class="cat-article">{{{ $article->categorie->nom }}}</a><!-- /.cat-article -->
                </div><!-- /.text-center -->
                @endif
            </div><!-- /.container -->
        </header><!-- /#header-page -->
        <section class=" pt-20 pt-10-xs pb-75 pb-50-md pb-30-xs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="wysiwyg-wp">
                            @if ($article->illustration)
                                <img src="{{ Croppa::url($article->illustration->cropPath, 1200, 600) }}" class="img-center" alt="{{ $article->illustration->tagAlt }}" />
                            @endif
                            @if ($article->extrait)
                            <p class="headline">{!! $article->extrait !!}</p>
                            @endif
                            {!! $article->texte !!}
                        </div><!-- .wysiwyg-wp -->
                    </div><!-- /.col-lg-10 -->
                </div><!-- /.row -->
            </div><!-- .content -->
        </section>
    </main><!-- #main-->

@stop