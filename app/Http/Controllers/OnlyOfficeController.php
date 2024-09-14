<?php

namespace App\Http\Controllers;

use App\Models\PatientReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OnlyOfficeController extends Controller
{
    public function openDocument($id)
    {
        
        $document = PatientReport::findOrFail($id);
        // Generate the URL to the document using the 'documents.show' route
        $documentUrl = route('documents.show', $document->id);
        // $documentUrl = Storage::url('patientDocuments/' . $document->file_name);
        $config = [
            "document" => [
                "fileType" => "docx", // Extract the file type
                "key" => uniqid(), // Unique identifier for the document
                "title" => $document->file_name,
                "url" => $documentUrl,
            ],
            "documentType" => "word",
            "editorConfig" => [
                // "callbackUrl" => route('onlyoffice.callback', $document->id),
                "permissions" => [
                    "edit" => true,
                    "download" => true,
                    "print" => true,
                    "read" => true,
                    "comment" => true,
                    "fillForms" => true,
                    "modifyFilter" => true,
                    "modifyContentControl" => true,
                    "review" => true,
                    // Add other permissions as needed
                ], // The callback URL after editing
            ],
        ];
        // Log the configuration array
        Log::info('ONLYOFFICE Editor Config:', $config);

        return view('onlyoffice.editor', compact('config'));
    }


	public function callback( Request $request, $id ) {
		// Get the input data from the request (JSON data from OnlyOffice)
		$data = $request->getContent();
		$document = PatientReport::findOrFail( $id );
		$filename = $document->file_name;
		$uploadPath = 'patientDocuments/';

		if ( ! $data ) {
			return response()->json( [ 'error' => 'Bad Request' ], 400 );
		}

		$data = json_decode( $data, true );

		// Check if the document status is 2 (indicating it should be saved)
		if ( isset( $data['status'] ) && $data['status'] == 2 ) {
			// Get the download URL for the updated document
			$downloadUri = $data['url'];

			if ( ! $downloadUri ) {
				return response()->json( [ 'error' => 'Bad Response' ], 400 );
			}

			// Specify the path where the document should be saved
			$pathForSave = storage_path( $uploadPath . $filename );

			// Download the updated document from OnlyOffice
			// $documentData = file_get_contents( $downloadUri );
			$documentData = @file_get_contents( $downloadUri );

			if ( $documentData === false ) {
				return response()->json( [ 'error' => 'Bad Response' ], 400 );
			}

			// Save the document to the specified path
			if ( file_put_contents( $pathForSave, $documentData ) === false ) {
				return response()->json( [ 'error' => 'Save Failed' ], 500 );
			}

			// Return a successful response to OnlyOffice
			return response()->json( [ 'error' => 0 ] );
		}

		// Return a response indicating no action was taken
		return response()->json( [ 'error' => 0 ] );
	}
}
