<?php

namespace App\Services;

use App\Repositories\GuestRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class GuestService
{
    protected $guestRepository;
    protected $phoneNumberService;

    public function __construct(GuestRepositoryInterface $guestRepository, PhoneNumberService $phoneNumberService)
    {
        $this->guestRepository = $guestRepository;
        $this->phoneNumberService = $phoneNumberService;
    }

    public function getAllGuests()
    {
        return $this->guestRepository->all();
    }

    public function getGuestById($id)
    {
        return $this->guestRepository->find($id);
    }

    public function createGuest(array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests',
            'phone' => 'required|string|unique:guests',
            'country' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if (empty($data['country'])) {
            $data['country'] = $this->phoneNumberService->getCountryFromPhone($data['phone']);
        }

        return $this->guestRepository->create($data);
    }

    public function updateGuest($id, array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests,email,' . $id,
            'phone' => 'required|string|unique:guests,phone,' . $id,
            'country' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if (empty($data['country'])) {
            $data['country'] = $this->phoneNumberService->getCountryFromPhone($data['phone']);
        }

        return $this->guestRepository->update($id, $data);
    }

    public function deleteGuest($id)
    {
        return $this->guestRepository->delete($id);
    }
}
