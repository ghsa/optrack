<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\UnauthorizedException;

// https://docs.oplab.com.br/
class OplabService implements StockTrackerInterface
{
    public function getAccessToken()
    {
        try {
            $response = Http::post(config('services.oplab.url') . '/users/authenticate', [
                'email' => config('services.oplab.email'),
                'password' => config('services.oplab.password'),
            ]);
            $data = $response->json();
            $accessToken = $data['access-token'];
            return $accessToken;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new UnauthorizedException("Error to create access Token");
        }
    }

    public function getStock($accessToken, Stock $stock)
    {
        try {
            $response = Http::withHeaders([
                'Access-Token' => $accessToken
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
