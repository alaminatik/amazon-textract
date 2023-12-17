<?php

namespace App\Http\Controllers;
// require 'vendor/autoload.php';

use Illuminate\Http\Request;
use Aws\Textract\TextractClient;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// require './aws-autoloader.php';

use Aws\Credentials\CredentialProvider;

class AmazoneTextractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        return view('fileupload');
    }

    public function index(Request $request)
    {
        
      // For aws S3

        //   require 'vendor/autoload.php';

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

        
        // require 'D:\xampp-php-7.4\htdocs\amazon-textract\vendor\autoload.php';
        // return 'test ok';
        
        // $textractClient = new TextractClient([
        //     'version' => 'latest',
        //     'region' => 'ap-south-1', // pass your region
        //     'credentials' => [
        //         'key'    => env('AWS_ACCESS_KEY_ID'),
        //         'secret' => env('AWS_SECRET_ACCESS_KEY')
        //         ]
               
        // ]);

        // return 'test ok';
        
        
        try {
            // return 'test ok';
            // $result = $textractClient->analyzeDocument([
            //     'Document' => [
            //         'S3Object' => [
            //             'Bucket' => 'bdtax-doc',
            //             'Name' => 'Screenshot_1.png',
            //         ],
            //     ],
            //     'FeatureTypes' => ['TABLES', 'FORMS'],
            // ]);

            // echo '<pre>';
            // print_r($result);
            // die();

            // foreach ($result['Blocks'] as $block) {
            //     if ($block['BlockType'] == 'KEY_VALUE_SET') {
            //         // Extract the label and value
            //         $label = '';
            //         $value = '';
            //         // if(!isset($block['Relationships'])){
            //         //     continue;  
            //         // }
            //         foreach ($block['Relationships'] as $relationship) {
            //             if ($relationship['Type'] == 'CHILD') {
            //                 foreach ($relationship['Ids'] as $childId) {
            //                     if(!isset($result['Blocks'][$childId])){
            //                      continue;   
            //                     }
            //                     $childBlock = $result['Blocks'][$childId];
                               
            //                     if ($childBlock['BlockType'] == 'WORD') {
            //                         // This is a label
            //                         $label .= $childBlock['Text'] . ' ';
            //                     } elseif ($childBlock['BlockType'] == 'SELECTION_ELEMENT') {
            //                         // This is a checkbox
            //                         $value .= ($childBlock['SelectionStatus'] == 'SELECTED') ? 'Yes' : 'No';
            //                     } else {
            //                         // This is a value
            //                         $value .= $childBlock['Text'] . ' ';
            //                     }
            //                 }
            //             }
            //         }
                    
            //         // Print out the label and value
            //         echo $label . ': ' . $value . '<br>';
            //     }
            // }

            /*
            $provider = CredentialProvider::env();
            $client = new TextractClient([
                'profile' => 'TextractUser',
                'region' => 'us-west-2',
                'version' => '2018-06-27',
                'credentials' => $provider
            ]);
            */
// return 'ok';
           

            // return $client;

            $request->validate([

                'file' => 'required|mimes:pdf,xlx,csv,jpg,png|max:2048',
    
            ]);
    
            $filename = time().'.'.$request->file->extension();  
            $request->file->move(public_path('/'), $filename);
    
            // return back()->with('success','You have successfully upload file.')->with('file',$fileName);
    
       
            $client = new TextractClient([
                'region' => 'ap-south-1',
                'version' => '2018-06-27',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ]
            ]);


            // The file in this project.

            $file = fopen($filename, "rb");
            $contents = fread($file, filesize($filename));
            fclose($file);

            $options = [
                'Document' => [
                    'Bytes' => $contents
                ],
                'FeatureTypes' => ['FORMS'], // REQUIRED
            ];
            $result = $client->analyzeDocument($options);
            // If debugging:
            // echo print_r($result, true);
            $blocks = $result['Blocks'];
            // Loop through all the blocks:
            foreach ($blocks as $key => $value) {
                if (isset($value['BlockType']) && $value['BlockType']) {
                    $blockType = $value['BlockType'];
                    if (isset($value['Text']) && $value['Text']) {
                        $text = $value['Text'];
                        // if ($blockType == 'WORD') {
                        //     echo "Word: ". print_r($text, true) . "\n";
                        // } else 
                        
                        if ($blockType == 'LINE') {
                            $paragraph[] = $text;
                            
                            // exit;
                            // echo "Line: ". print_r($text, true) . "\n";
                        }
                    }
                }
            }
            
            $concatenatedText = implode(" ", $paragraph);
            $cont = $text;
            // echo '<pre>';
            print_r($concatenatedText);
            
           

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
