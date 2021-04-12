<?php

namespace Src\Controllers;

use Src\Models\Movie;
use Src\Services\MovieService;
use Src\System\Request;
use Src\Traits\Validation;

class MovieController extends Controller
{
    use Validation;

    private $movieService;

    public function __construct()
    {
        $this->movieService = new MovieService();
    }

    public function get(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $movie = Movie::find($request->getId());
        if (!$movie) {
            return $this->notFoundResponse();
        }
        return $this->successResponse($movie, 'Movie');
    }

    public function getAlL(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $movies = Movie::findAll();
        return $this->successResponse($movies, 'Movies list');
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
        return $this->movieService->create($request->getBody());
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
        $movie = Movie::find($request->getId());
        if (!$movie) {
            return $this->notFoundResponse();
        }
        return $this->movieService->update($request->getId(), $request->getBody());
    }

    public function delete(Request $request): string
    {
        if (!$this->auth($request)) {
            return $this->unauthorizedResponse('user not authorize');
        }
        $movie = Movie::find($request->getId());
        if (!$movie) {
            return $this->notFoundResponse();
        }
        return $this->movieService->delete($request->getId());
    }

    private function validateData(): array
    {
        return [
            'title' => ['required', 'min' => 2, 'max' => 150, 'string'],
            'description' => ['required','min' => 2, 'max' => 300, 'string'],
            'year' => ['required', 'year', 'int'],
            'director' => ['required', 'max' => 100, 'string'],
            'release_date' => ['required']
        ];
    }
}
