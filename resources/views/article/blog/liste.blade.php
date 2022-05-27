@extends('layouts.website')
@section('title', $page->tag_title)
@section('description', $page->tag_meta_description)

@section('content')

    <main id="main">
        <header id="header-page">
            <div class="container">
                <h1 class="title">{{ $page->titre ? $page->titre : $page->nom }}</h1>
                @if ($page->extrait || $page->description)
                    <div class="wysiwyg-wp mt-20"><p>{!! $page->extrait ? $page->extrait : $page->description !!}</p></div>
                @endif
            </div><!-- /.container -->
        </header><!-- /#header-page -->
        <section class="container mb-75 mb-50-sm mb-30-xs">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                </div><!-- /.col-md-4 -->
                <div class="col-lg-9 col-md-8 pl-50 pl-30-md pl-15-sm mt-15-xs">
                    <div class="row blog-cta-wp">
                        @foreach ($articles as $article)
                            <div class="col-lg-4 col-sm-6 mb-30 mb-15-xs" data-aos="zoom-in">
                                @include('article.blog._article')
                            </div><!-- /.col-lg-4 -->
                        @endforeach
                    </div><!-- /.row -->
                    {{ $articles->links() }}
                </div><!-- /.col-md-8 -->
            </div>
        </section><!-- /.container -->
    </main><!-- #main-->
@stop
