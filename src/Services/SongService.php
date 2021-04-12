<?php

namespace Src\Services;

use Src\Controllers\Controller;
use Src\Models\Song;

class SongService extends Controller
{
    public function create($data): string
    {
        try {
            $song = Song::create([
                'title' => $data['title'],
                'album_name' => $data['album_name'],
                'year' => $data['year'],
                'artist' => $data['artist'],
                'release_date' => $data['release_date'],
            ]);
            return $this->cratedResponse($song);
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function update($id, $data): string
    {
        try {
            $song = Song::update($id, $data);
            return $this->successResponse($song, 'Updated');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function delete($id): string
    {
        try {
            Song::delete($id);
            return $this->successResponse(null, 'Deleted');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }
}