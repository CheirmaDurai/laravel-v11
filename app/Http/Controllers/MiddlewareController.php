<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiddlewareController extends Controller
{
    public function preProcessor(Request $request)
    {
        $request->mergeIfMissing(['custom_input' => 'value set in controller']);
        return response()->json(['type' => 'Update the request class properties', 'data' => $request->all()]);
    }

    public function postProcessor(Request $request)
    {
        return response()->json([
            'type' => 'Update the response class properties',
            'cookie' => [
                'name' => $request->cookie('name'),
            ]
        ]);
    }

    public function middlewarePreAndPostProcessor(Request $request)
    {
        return response()->json([
            'type' => 'Update the request and respose class properties',
            'data' => $request->all(),
            'cookie' => [
                'name' => $request->cookie('name'),
            ]
        ]);
    }
}
