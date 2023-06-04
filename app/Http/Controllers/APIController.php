<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

/**
 * menampilkan json versi public
 */
class APIController extends BaseController
{
    /**
     * Dump api-docs content endpoint. Supports dumping a json, or yaml file.
     *
     * @param string $file
     *
     * @return \Illuminate\Http\Response
     */
    public function docs(string $file = null)
    {
        $jsonFile = public_path(config("l5-swagger.documentations.default.paths.docs_json"));
        $content = File::get($jsonFile);

        return Response::make($content, 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    public function api()
    {
        // Need the / at the end to avoid CORS errors on Homestead systems.
        return Response::make(
            view('l5-swagger::index', [
                'documentation' => 'default',
                'secure' => Request::secure(),
                'urlToDocs' => route('l5-swagger.public.docs', config('l5-swagger.documentations.default.paths.docs_json', 'api-docs.json')),
                'operationsSorter' => config('l5-swagger.defaults.operations_sort'),
                'configUrl' => config('l5-swagger.defaults.additional_config_url'),
                'validatorUrl' => config('l5-swagger.defaults.validator_url'),
            ]),
            200
        );
    }

    public function hrDocs(string $file = null)
    {
        $jsonFile = public_path(config("l5-swagger.documentations.hr.paths.docs_json"));
        $content = File::get($jsonFile);

        return Response::make($content, 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    public function hrApi()
    {
        return Response::make(
            view('l5-swagger::index', [
                'documentation' => 'hr',
                'secure' => Request::secure(),
                'urlToDocs' => route('l5-swagger.hr_public.docs', config('l5-swagger.documentations.hr.paths.docs_json', 'hr-api-docs.json')),
                'operationsSorter' => config('l5-swagger.defaults.operations_sort'),
                'configUrl' => config('l5-swagger.defaults.additional_config_url'),
                'validatorUrl' => config('l5-swagger.defaults.validator_url'),
            ]),
            200
        );
    }
}
