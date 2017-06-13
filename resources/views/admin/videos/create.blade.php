@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @component('admin.videos.tabs-component')
                <div class="col-md-12">
                    @slot('title')
                        <h4>Novo Vídeo</h4>
                    @endslot
                    <?php $icon = Icon::create('floppy-saved') ?>
                    {!!
                        form($form->add('salvar', 'submit', [
                            'attr'=>['class'=>'btn btn-primary btn-block'],
                            'label' => $icon
                        ]))
                     !!}
                </div>
            @endcomponent
        </div>
    </div>
@endsection