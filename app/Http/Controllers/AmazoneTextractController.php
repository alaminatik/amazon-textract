<?php

namespace App\Http\Controllers;
// require 'vendor/autoload.php';

use Illuminate\Http\Request;
use Aws\Textract\TextractClient;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class AmazoneTextractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
      // For aws S3

        // $client = new TextractClient([
        //     'version' => 'latest',
        //     'region' => env('AWS_DEFAULT_REGION'),
        //     'credentials' => [
        //         'key' => env('AWS_ACCESS_KEY_ID'),
        //         'secret' => env('AWS_SECRET_ACCESS_KEY')
        //     ]
        // ]);

        // $response = $client->detectDocumentText([
        //     'Document' => [
        //         'S3Object' => [
        //             'Bucket' => $bucket_name,
        //             'Name' => $object_name
        //         ]
        //     ]
        // ]);

        // foreach ($response['Blocks'] as $block) {
        //     if ($block['BlockType'] == 'LINE') {
        //         echo $block['Text'];
        //     }
        // }


        // For local PC

        
        require 'E:\XAMPP-7.4\htdocs\amazontextract\vendor\autoload.php';
     
 
        $textractClient = new TextractClient([
            'version' => 'latest',
            'region' => 'ap-south-1', // pass your region
            'credentials' => [
                'key'    => 'AKIAW4SQVCR7MNCSMI4R',
                'secret' => 'nQF0pWNQlZ5Co1cmkX4fy7xPTWDEm2w3GHhROWNy'
            ]
        ]);

        
        
        try {
            // return 'test ok';
            $result = $textractClient->detectDocumentText([
                'Document' => [
                    'Bytes' => file_get_contents(getcwd().'/2.png'),
                ]
            ]);

            

            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] != 'WORD') continue;
                 
                echo $block['Text']." ";
            }

            // echo '<pre>';
            // print_r($block['Text']);
            // die();

        } catch (Aws\Textract\Exception\TextractException $e) {
            // output error message if fails
            echo $e->getMessage();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
