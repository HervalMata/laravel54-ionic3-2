@php
    $tabs = [
        [
            'title' => 'Informações',
            'link' => !isset($video) ? route('admin.videos.create'): route
            ('admin.videos.edit', ['video' => $video->id])
        ],
        [
            'title' => 'Série e Categoria',
            'link' => !isset($video) ? '#' : route('admin.videos.relations.create', ['video' => $video->id]),
            'disabled' => !isset($video) ? true : false,
        ],
        [
            'title' => 'Vídeo e Thumbnail',
            'link' => '#'
        ]
    ];
@endphp
<h3>Gerenciar Vídeo</h3>
<div class="text-right">
    {!! Button::link('Listar Vídeos')->asLinkTo(route('admin.videos.index')) !!}
</div>
{!! Navigation::tabs($tabs) !!}
<div>
    {!! $title !!}
    {!! $slot !!}
</div>
