<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UrgentNotification;
use Illuminate\Http\Request;
use App\Models\ProviderDocumentsFolder;
use App\Models\ProviderDocuments;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;

class ProviderDocumentsController extends Controller
{
    // view for provider to show and insert file for individual
    public function providerView($providerId, $doctorId)
    {
        $folders = ProviderDocumentsFolder::where('provider_id', $providerId)->where('doctor_id', $doctorId)->get();
        $providerFolderId = $providerId;
        $doctorFolderId = $doctorId;
        return view('provider.providerview', compact('folders', 'providerFolderId', 'doctorFolderId'));
    }

    // provider folder insert
    public function providerFolderInsert(Request $request)
    {
        DB::beginTransaction();

        try {
            $folder = ProviderDocumentsFolder::create([
                'folder_name' => $request->name,
                'provider_id' => $request->providerFolderId,
                'doctor_id' => $request->doctorFolderId,
                'date' => $request->date ?? Carbon::today()->toDateString()
            ]);

            DB::commit();

            return redirect()->back()->with('success');
        } catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->with('error');
        }
    }

    // provider folder delete
    public function providerFolderDelete($id)
    {
        $providerFolder = ProviderDocumentsFolder::findOrfail($id)->delete();

        return redirect()->back()->with('success');
    }

    // bulk provider folder delete
    public function providerFolderBulkDelete(Request $request)
    {
        if ($request->ids != null) {
            $bulkProviderFolder = ProviderDocumentsFolder::whereIn('id', $request->ids)->delete();
            return redirect()->back()->with('success');
        } else {
            return redirect()->back()->with('error');
        }
    }

    // provider insert files
    public function providerFileInsert(Request $request)
    {

        // $randomNumber = rand(10000000, 999999);
        $file = $request->file('file');
        $uploadPath = 'providerdocuments/';

        $filename = $file->getClientOriginalName();

        // Get the file extension and the name without the extension
        $fileExtension = $file->getClientOriginalExtension();
        $fileNameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);

        $path = $uploadPath . $filename;

        $i = 1;
        // Check if the file already exists
        while (Storage::disk('local')->exists($path)) {
            // Append the number to the file name
            $filename = $fileNameWithoutExtension . '_' . $i . '.' . $fileExtension;
            $path = $uploadPath . $filename;
            $i++;
        }

        // Save the file
        Storage::disk('local')->put($path, file_get_contents($file));

        // Save the file details in the database
        $upload = ProviderDocuments::create([
            'file_name' => $filename,
            'file_path' => $path,
            'folder_id' => $request->id
        ]);

        // Notify admin and super admin
        Notification::create([
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'folder_id' => $request->id,
            'message' => "A new file has been added by " . Auth::user()->name,
        ]);
        // }

        // new code 
        return response()->json([
            'success' => true,
            'file' => $upload
        ]);
    }

    // download file 
    public function providerFileDownload($id)
    {
        $providerDocument = ProviderDocuments::findOrFail($id);

        if ($providerDocument) {
            return Storage::download($providerDocument->file_path);
        }
    }

    // bulk file download
    public function providerBulkFileDownload(Request $request)
    {
        $ids = $request->input('ids');

        $providerDocuments = ProviderDocuments::whereIn('id', $ids)->get();

        if ($providerDocuments->isEmpty()) {
            return back()->with('error', 'No files selected or files not found.');
        }

        $zipFileName = 'provider_documents_' . time() . '.zip';

        $zip = new ZipArchive;

        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($providerDocuments as $providerDocument) {
                $filePath = storage_path($providerDocument->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }

            $zip->close();
        } else {
            return back()->with('error', 'Failed to create ZIP file.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    // ajax get report table
    public function providerFileReports(Request $request)
    {
        $id = $request->input('id');
        $reports = ProviderDocuments::where('folder_id', $id)->get();

        return view('provider.ajax_load_reports', compact('reports', 'id'));
    }

    // ajax file favourite
    public function providerFileFavourite($id)
    {

        $file = ProviderDocuments::findOrFail($id);
        if ($file->favourites == 1) {
            $favourites = $file->update([
                'favourites' => 2
            ]);
            return response()->json(['result' => 2]);
        } elseif ($file->favourites == 2) {
            $favourites = $file->update([
                'favourites' => 1
            ]);
            return response()->json(['result' => 1]);
        } else {
            return response()->json(['error']);
        }
    }


    //File Open

    public function providerFileOpen($id)
    {
        // dd($id);
        $providerDocument = ProviderDocuments::findOrFail($id); // Fetch the document by ID

        if (!$providerDocument) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        // Assuming the document is stored in a storage path
        $path = storage_path($providerDocument->file_path);

        return response()->file($path);
    }

    // file delete
    public function providerFileDelete($id)
    {
        // $fileDelete = ProviderDocuments::findOrFail($id)->delete();

        // return redirect()->back()->with('success');


        //New Code for delete files permanently


        // Find the document
        $document = ProviderDocuments::findOrFail($id);

        // Get the file path (assuming the file path is stored in a column like 'file_path')
        $filePath = $document->file_path;

        // Check if the file exists and delete it
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Now delete the database record
        $document->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Document and file deleted successfully');
    }

    // bulk file delete
    public function providerBulkFileDelete(Request $request)
    {
        // $fileBulkDelete = ProviderDocuments::whereIn('id', $request->ids)->delete();

        // return redirect()->back()->with('success');

        //New Code for delete files permanently

        if ($request->ids != null) {
            // Retrieve the documents based on selected IDs
            $documents = ProviderDocuments::whereIn('id', $request->ids)->get();
    
            // Loop through each document and delete the associated file
            foreach ($documents as $document) {
                $filePath = $document->file_path; // Assuming this column holds the file path
                
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
    
            // Delete the records from the database
            ProviderDocuments::whereIn('id', $request->ids)->delete();
    
            return redirect()->back()->with('success', 'Documents and files deleted successfully');
        } else {
            return redirect()->back()->with('error', 'No documents selected for deletion');
        }
    }

    // file urgent status
    public function providerFileUrgent($id)
    {
        $fileUrgent = ProviderDocuments::where('id', $id)->update([
            'urgent' => 1
        ]);

        $file = ProviderDocuments::where('id', $id)->first();

        // Notify admin and super admin
        UrgentNotification::create([
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'file_id' => $id,
            'folder_id' => $file->folder_id,
            'message' => "A file has been marked as urgent by the " . Auth::user()->name,
        ]);

        // return redirect()->back()->with('success');
        return response()->json([
            'success' => true,
            'urgent' => 1,
        ]);
    }

    // file remove urgent status
    public function providerFileRemoveUrgent($id)
    {
        $fileRemoveUrgent = ProviderDocuments::where('id', $id)->update([
            'urgent' => 2
        ]);

        // return redirect()->back()->with('success');
        return response()->json([
            'success' => true,
            'urgent' => 2,
        ]);
    }

    // file search
    public function searchReports(Request $request)
    {
        $query = $request->get('search');
        $id = $request->get('id');

        $reports = ProviderDocuments::where('folder_id', $id)->where('file_name', 'LIKE', "%{$query}%")
            ->get();

        return view('provider.report_list', compact('reports'))->render();
    }

    // provider file name update
    public function providerFileUpdateName(Request $request)
    {

        $updateName = ProviderDocuments::where('id', $request->id)->update([
            'file_name' => $request->name,
        ]);

        return redirect()->back()->with('success');
    }

    // ajax provider file name
    public function providerFileGetName($id)
    {
        $fileName = ProviderDocuments::findOrFail($id);

        return response()->json([
            'id' => $fileName->id,
            'file' => $fileName->file_name
        ]);
    }
}
