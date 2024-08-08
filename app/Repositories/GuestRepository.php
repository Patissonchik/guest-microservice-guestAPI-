<?php

namespace App\Repositories;

use App\Models\Guest;

class GuestRepository implements GuestRepositoryInterface
{
    public function all()
    {
        return Guest::all();
    }

    public function find($id)
    {
        return Guest::find($id);
    }

    public function create(array $data)
    {
        return Guest::create($data);
    }

    public function update($id, array $data)
    {
        $guest = Guest::find($id);
        if ($guest) {
            $guest->update($data);
            return $guest;
        }
        return null;
    }

    public function delete($id)
    {
        $guest = Guest::find($id);
        if ($guest) {
            $guest->delete();
            return true;
        }
        return false;
    }
}
