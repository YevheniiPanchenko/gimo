<?php

namespace Src\Services;

use Src\Controllers\Controller;
use Src\Models\Movie;

class MovieService extends Controller
{
    public function create($data): string
    {
        try {
            $movie = Movie::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'year' => $data['year'],
                'director' => $data['director'],
                'release_date' => $data['release_date'],
            ]);
            return $this->cratedResponse($movie);
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function update($id, $data): string
    {
        try {
            $movie = Movie::update($id, $data);
            return $this->successResponse($movie, 'Updated');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function delete($id): string
    {
        try {
            Movie::delete($id);
            return $this->successResponse(null, 'Deleted');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }
}