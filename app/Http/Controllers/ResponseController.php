<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response {
        return response("Hello Response");
    }

    public function header(Request $request):Response {
        $body = ['firstName' => 'Randi', 'LastName' => 'Febriadi'];

        return response(json_encode($body), 200)->header('Content-Type', 'application/json')->withHeaders([
            'Author' => 'Randi Programmer Hebat',
            'App' => 'Belajar Laravel'
        ]); 
    }

    public function responseView(Request $request):Response {
        return response()->view('hello', ['name' => 'Randi']);
    }

    public function responseJson(Request $request):JsonResponse {
        $body = ['firstName' => 'Randi', 'lastName' => 'Febriadi'];
        return response()->json($body);
    }

    public function responseFile(Response $response):BinaryFileResponse {
        return response()->file(storage_path('app/public/pictures/1.png'));
    }

    public function responseDownload(Response $response):BinaryFileResponse {
        return response()->download(storage_path('app/public/pictures/1.png'));
    }
}