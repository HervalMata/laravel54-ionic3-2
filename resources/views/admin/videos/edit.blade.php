@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @component('admin.videos.tabs-component',
            ['video' => $form->getModel()])
                <div class="col-md-12">
                    @slot('title')
                        <h4>Editar Vídeo</h4>
                    @endslot
                    <?php $icon = Icon::create('pencil') ?>
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