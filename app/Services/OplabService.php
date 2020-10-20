<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\UnauthorizedException;

// https://docs.oplab.com.br/
class OplabService implements StockTrackerInterface
{
    public function getAccessToken(User $user)
    {
        if ($user->oplab_email == null || $user->oplab_password == null) {
            throw new UnauthorizedException("No email or password information.");
        }
        try {
            $response = Http::post(config('services.oplab.url') . '/users/authenticate', [
                'email' => $user->oplab_email,
                'password' => $user->oplab_password,
            ]);
            $data = $response->json();
            $accessToken = $data['access-token'];
            $user->oplab_token = $accessToken;
            $user->save();
            return $accessToken;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new UnauthorizedException("Error to create access Token");
        }
    }

    public function getStock(Stock $stock)
    {
        if (empty($stock->user->oplab_token)) {
            throw new UnauthorizedException("Not authorized");
        }

        try {
            $response = Http::withHeaders([
                'Access-Token' => $stock->user->oplab_token
            ])
                ->get(config('services.oplab.url') . '/studies/' . $stock->initials, []);
            $data = $response->json();
            return [
                'info' => $data['target'],
                'series' => $data['series']
            ];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
