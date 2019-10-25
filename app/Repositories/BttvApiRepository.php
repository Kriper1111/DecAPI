<?php

namespace App\Repositories;

use App\Services\BttvApiClient;

use App\Http\Resources\Bttv as Resource;

class BttvApiRepository
{
    /**
     * @var App\Services\BttvApiClient
     */
    private $client;

    public function __construct(BttvApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves user information based on their BetterTTV user ID.
     *
     * @param string $userId
     *
     * @return App\Http\Resources\Bttv\User
     */
    public function userById($userId = '')
    {
        $request = $this->client->get('/users/' . $userId);

        if (isset($request['message'])) {
            throw new BttvApiException(sprintf('Error occurred retrieving information for user ID: %s - %s', $userId, $request['message']));
        }

        $userData = collect($request);

        return Resource\User::make($userData)
                            ->resolve();
    }
}
