@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de Vídeos</h3>
            {!! Button::primary('Novo Vídeo')
                ->asLinkTo(route('admin.videos.create'))
                ->prependIcon(Icon::plus())
            !!}
        </div>
        <br>
        <div class="row">
            {!! Table::withContents($videos->items())
                ->striped()
                ->callback('Descrição', function ($field, $v) {
                    return \Bootstrapper\Facades\MediaObject::withContents(
                        [
                            'image' => $v->thumb_small_path,
                            'link' => $v->file_path,
                            'heading' => $v->title,
                            'body' => $v->description
                        ]
                    );
                })
                ->callback('Ações', function ($field, $v) {
                    $linkEdit = route('admin.videos.edit', ['video' => $v->id]);
                    $linkShow = route('admin.videos.show', ['video' => $v->id]);
                    return Button::link(Icon::create('pencil'))
                            ->asLinkTo($linkEdit) . '|'.
                            Button::link(Icon::create('remove'))
                            ->asLinkTo($linkShow);
                })
            !!}
        </div>
        {!! $videos->links() !!}
    </div>
@endsection

@push('styles')
<style type="text/css">
    .media-body{
        width: auto;
    }
</style>
@endpush