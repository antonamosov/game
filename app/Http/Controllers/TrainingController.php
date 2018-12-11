<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingStoreRequest;
use App\Http\Resources\TrainingResource;
use App\Models\Game;

class TrainingController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respond([
            'data' => TrainingResource::collection(\Auth::user()->getAllTrainings())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingStoreRequest $request)
    {
        $user = \Auth::user();
        $game = $user->games()->create(array_merge($request->all(), [
            'type' => Game::TYPE_TRAINING,
            'status' => Game::STATUS_ACTIVE
        ]));

        return $this->respond([
            'data' => [
                'id' => $game->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->respond([
            'data' => new TrainingResource(Game::findOrFail($id))
        ]);
    }
}
