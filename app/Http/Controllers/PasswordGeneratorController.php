<?php

namespace App\Http\Controllers;

use App\Http\Requests\Generate\StoreGenerateRequest;
use App\Services\PasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordGeneratorController extends Controller
{
    private readonly PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function index()
    {
        return view('show_password');
    }

    public function generate(StoreGenerateRequest $request)
    {
        // The validated data is automatically available
        $data = $request->validated();

        $password = $this->passwordService->generateUniquePassword(
            $data['length'],
            $data['useDigits'],
            $data['useUppercase'],
            $data['useLowercase']
        );

        return response()->json(['password' => $password]);
    }
}
