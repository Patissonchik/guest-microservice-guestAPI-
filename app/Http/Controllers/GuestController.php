<?php

namespace App\Http\Controllers;

use App\Services\GuestService;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    protected $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    public function index()
    {
        $guests = $this->guestService->getAllGuests();
        return response()->json($guests);
    }

    public function store(Request $request)
    {
        try {
            $guest = $this->guestService->createGuest($request->all());
            if (isset($guest['errors'])) {
                return response()->json($guest, 422);
            }
            return response()->json($guest, 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $guest = $this->guestService->updateGuest($id, $request->all());
            if (isset($guest['errors'])) {
                return response()->json($guest, 422);
            }
            return response()->json($guest, 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $guest = $this->guestService->getGuestById($id);
        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }
        return response()->json($guest);
    }

    public function destroy($id)
    {
        $success = $this->guestService->deleteGuest($id);
        if (!$success) {
            return response()->json(['message' => 'Guest not found'], 404);
        }
        return response()->json(['message' => 'Guest deleted']);
    }
}
