@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de Categorias</h3>
            {!! Button::primary('Nova Serie')
                ->asLinkTo(route('admin.series.create'))
                ->prependIcon(Icon::plus())
            !!}
        </div>
        <br>
        <div class="row">
            {!! Table::withContents($series->items())
                ->striped()
                ->callback('Descrição', function ($field, $serie) {
                    return \Bootstrapper\Facades\MediaObject::withContents(
                        [
                            'image' => $serie->thumb_small_asset,
                            'link' => '#',
                            'heading' => $serie->title,
                            'body' => $serie->description
                        ]
                    );
                })
                ->callback('Ações', function ($field, $serie) {
                    $linkEdit = route('admin.series.edit', ['serie' =>
                    $serie->id]);
                    $linkShow = route('admin.series.show', ['serie' =>
                    $serie->id]);

                    return Button::link(Icon::create('pencil'))
                            ->asLinkTo($linkEdit) . '|'.
                            Button::link(Icon::create('remove'))
                            ->asLinkTo($linkShow);
                })
            !!}
        </div>
        {!! $series->links() !!}
    </div>
@endsection

@push('styles')
<style type="text/css">
    table > thead > tr > th:nth-child(3){
        width: 50%;
    }
</style>
@endpush