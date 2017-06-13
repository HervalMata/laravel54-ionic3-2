<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Models\Video;
use FormBuilder;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class VideoRelationsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Video $video)
    {
        $form = FormBuilder::create('CodeFlix\Forms\VideoRelationForm', [
            'method' => 'POST',
            'url' => route('admin.videos.relations.store', ['video' =>
                $video->id]),
            'model' => $video
        ]);

        return view('admin.videos.relation', compact('form'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
}
