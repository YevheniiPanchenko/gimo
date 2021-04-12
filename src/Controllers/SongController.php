<?php

namespace Src\Controllers;

use Src\Models\Song;
use Src\Services\SongService;
use Src\System\Request;
use Src\Traits\Validation;

class SongController extends Controller
{
    use Validation;

    private $songService;

    public function __construct()
    {
        $this->songService = new SongService();
    }

    public function get(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $song = Song::find($request->getId());
        if (!$song) {
            return $this->notFoundResponse();
        }
        return $this->successResponse($song, 'Song');
    }

    public function getAlL(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $song = Song::findAll();
        return $this->successResponse($song, 'Songs list');
    }

    public function create(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $validation = $this->validate($request->getBody(), $this->validateData());
        if (!empty($validation)) {
            return $this->validationErrorResponse($validation);
        }
        return $this->songService->create($request->getBody());
    }

    public function update(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $validation = $this->validate($request->getBody(), $this->validateData());
        if (!empty($validation)) {
            return $this->validationErrorResponse($validation);
        }
        return $this->songService->update($request->getId(), $request->getBody());
    }

    public function delete(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $song = Song::find($request->getId());
        if (!$song) {
            return $this->notFoundResponse();
        }
        return $this->songService->delete($request->getId());
    }

    private function validateData(): array
    {
        return [
            'title' => ['required', 'min' => 2, 'max' => 150, 'string'],
            'album_name' => ['required','min' => 2, 'max' => 150, 'string'],
            'year' => ['required', 'year', 'int'],
            'artist' => ['required', 'min' => 2, 'max' => 100, 'string'],
            'release_date' => ['required']
        ];
    }
}
