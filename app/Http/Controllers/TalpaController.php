<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TalpaController extends Controller
{
    function fetchData(){
        $query = <<<GRAPHQL
        {
            station(slug: "radio-10") {
                id
                slug
                getPlayouts(limit: 1) {
                    playouts {
                        broadcastDate
                        rankings {
                            listName
                            position
                            __typename
                        }
                        track {
                            id
                            title
                            artistName
                            isrc
                            images {
                                type
                                uri
                                __typename
                            }
                            __typename
                        }
                        __typename
                    }
                }
            }
        }
        GRAPHQL;

        // The API URL and API key
        $url = 'https://graph.talparad.io/';
        $apiKey = 'da2-bvmhv52heveqxltvhqvfeeimce';

        // Make the API request using Laravel's Http client
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'profile' => 'radio-brand-web',
        ])->post($url, ['query' => $query]);

        // Return the API response with CORS headers
        if ($response->successful()) {
            return response()->json($response->json())
                ->header('Access-Control-Allow-Origin', '*') // Allow all origins
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        // Handle errors with CORS headers
        return response()->json([
            'error' => 'Failed to fetch data',
            'details' => $response->body(),
        ], $response->status())
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
