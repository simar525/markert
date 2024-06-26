@extends('themes.basic.items.layout')
@section('title', $item->name)
@section('breadcrumbs', Breadcrumbs::render('items.view', $item))
@section('og_image', $item->getPreviewImageLink())
@section('description', shorterText(strip_tags($item->description), 155))
@section('keywords', $item->tags)
@section('content')
    <div
        class="description {{ @$settings->item->reviews_status || @$settings->item->comments_status || @$settings->item->changelogs_status ? 'border-top pt-3' : '' }}">
        <div class="item-single-paragraph">
            {!! $item->description !!}
        </div>
    </div>
@endsection
