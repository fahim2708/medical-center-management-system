<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Provider;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\PatientReport;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PatientReportsController extends Controller
{
    // patient view 
    public function patientView(Request $request, $id)
    {
        $patient = $id;
        $providers = Provider::get();
        $doctors = Doctor::get();

        $search = request()->input('search');
        $query = PatientReport::where('patient_id', $patient);
        if ($search) {
            $providerIds = Provider::where('name', 'LIKE', "%{$search}%")->pluck('id')->toArray();
            $query->where(function ($q) use ($search, $providerIds) {
                $q->whereIn('provider_id', $providerIds)
                    ->orWhere('document_type', 'LIKE', "%{$search}%");
            });
        }
        $patientReports = $query->orderBy('created_at', 'desc')->paginate(10);

        $patientName = Patient::where('id', $id)->firstOrFail();
        return view('patientreport.patientview', compact('providers', 'patient', 'patientReports', 'patientName', 'doctors'));
    }

    // patient report submit
    // public function patientReportsubmit(Request $request)
    // {
    //     $file = $request->file('file');
    //     $uploadPath = 'patientDocuments/';
    //     $filename = $file->getClientOriginalName();
    //     $request->file('file')->move(storage_path($uploadPath), $filename);
    //     $fileExtension = $file->getClientOriginalExtension();
    //     $fileNameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
    //     $path = $uploadPath . $filename;
    //     $i = 1;
    //     while (Storage::disk('local')->exists($path)) {
    //         // Append the number to the file name
    //         $filename = $fileNameWithoutExtension . '_' . $i . '.' . $fileExtension;
    //         $path = $uploadPath . $filename;
    //         $i++;
    //     }
    //     Storage::disk('local')->put($path, file_get_contents($file));

    //     $patientReport = PatientReport::create([
    //         'file_name' => $filename,
    //         'file_path' => $path,
    //         'patient_id' => $request->patient_id,
    //         'provider_id' => $request->provider_id,
    //         'document_type' => $request->document_type,
    //         'visit_date' => $request->visit_date,
    //         'description' => $request->description,
    //         'note' => $request->note
    //     ]);

    //     return redirect()->back()->with('success');
    // }

    public function patientReportsubmit(Request $request)
    {

        // Validate the request, ensuring that a file is provided
        $request->validate([
            'file' => 'required|file', // Ensure the file is required
        ]);

        $file = $request->file('file');
        $uploadPath = 'patientDocuments/';
        $filename = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $fileNameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);

        // Generate a unique filename if the file already exists
        $path = storage_path($uploadPath . $filename);
        $i = 1;
        while (file_exists($path)) {
            // Append the number to the file name
            $filename = $fileNameWithoutExtension . '_' . $i . '.' . $fileExtension;
            $path = storage_path($uploadPath . $filename);
            $i++;
        }

        // Move the file to the storage/patientDocuments directory
        $file->move(storage_path($uploadPath), $filename);

        // Save file information to the database
        $patientReport = PatientReport::create([
            'file_name' => $filename,
            'file_path' => $uploadPath . $filename, // Save the relative path
            'patient_id' => $request->patient_id,
            'provider_id' => $request->provider_id,
            'doctor_id' => $request->doctor_id ?? null,
            'document_type' => $request->document_type,
            'visit_date' => $request->visit_date,
            'description' => $request->description,
            'note' => $request->note
        ]);

        return redirect()->back()->with('success', 'Patient report submitted successfully.');
    }


    // patient report delete
    public function patientReportDelete($id)
    {
        // $reportdelete = PatientReport::findOrfail($id)->delete();

        // return redirect()->back()->with('success');


        //New Code for delete files permanently
        // Retrieve the report by ID
        $report = PatientReport::findOrFail($id);

        // Get the file path (assuming you store it in a column called 'file_path')
        $filePath = $report->file_path;

        // Check if the file exists in storage and delete it
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Now delete the report from the database
        $report->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Report and file deleted successfully');
    }

    // patient report bulk delete
    public function patientReportBulkdelete(Request $request)
    {
        // if ($request->ids != null) {
        //     $bulkReportDelete = PatientReport::whereIn('id', $request->ids)->delete();
        //     return redirect()->back()->with('success');
        // } else {
        //     return redirect()->back()->with('error');
        // }

        
        //New Code for delete files permanently

        if ($request->ids != null) {
            // Get the reports to be deleted
            $reports = PatientReport::whereIn('id', $request->ids)->get();
            
            // Loop through each report and delete the file if it exists
            foreach ($reports as $report) {
                $filePath = $report->file_path; // Make sure this column holds the file path
                
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
    
            // Now delete the records from the database
            PatientReport::whereIn('id', $request->ids)->delete();
    
            return redirect()->back()->with('success', 'Reports and files deleted successfully');
        } else {
            return redirect()->back()->with('error', 'No reports selected for deletion');
        }

    }

    // patient report bulk downlaod
    public function patientReportBulkdownlaod(Request $request)
    {
        $ids = $request->input('ids');

        $patientReports = PatientReport::whereIn('id', $ids)->get();

        if ($patientReports->isEmpty()) {
            return back()->with('error', 'No files selected or files not found.');
        }

        // $zipFileName = 'patientReport_' . time() . '.zip';
        $zipFileName = 'patientReport_' . date('d-m-Y') . '_' . time() . '.zip';

        $zip = new ZipArchive;

        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($patientReports as $patientReport) {
                $filePath = storage_path($patientReport->file_path);
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

    // patient approved reports
    public function approvedReports(Request $request)
    {

        $providers = Provider::get();
        $doctors = Doctor::get();
        // $query = PatientReport::with('patient')->where('status', 1)->orderBy('created_at', 'desc');
        $query = PatientReport::whereHas('patient', function ($query) {
            $query->whereNull('deleted_at');
        })->where('status', 1)->orderBy('created_at', 'desc');

        if ($request->filled('provider')) {
            $query->where('provider_id', $request->input('provider'));
        }
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->input('doctor'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $patientIds = Patient::where('last_name', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->pluck('id');

            $query->whereIn('patient_id', $patientIds);

            // $query->orWhere('document_type', 'LIKE', "%{$search}%")
            //       ->orWhere('note', 'LIKE', "%{$search}%");
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('visit_date', [$startDate, $endDate]);
        }

        // $approvedReports = $query->paginate(25);
        return view('patientreport.approvedreports', [
            'query' => $query->paginate(25),
            'providers' => $providers,
            'doctors' => $doctors,
        ]);
    }

    // patient pending reports
    public function pendingReports(Request $request)
    {
        $providers = Provider::get();
        $doctors = Doctor::get();
        // $query = PatientReport::with('patient')->where('status', 2)->orderBy('created_at', 'desc');
        $query = PatientReport::whereHas('patient', function ($query) {
            $query->whereNull('deleted_at');
        })->where('status', 2)->orderBy('created_at', 'desc');

        if ($request->filled('provider')) {
            $query->where('provider_id', $request->input('provider'));
        }
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->input('doctor'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $patientIds = Patient::where('last_name', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->pluck('id');

            $query->whereIn('patient_id', $patientIds);

            // $query->orWhere('document_type', 'LIKE', "%{$search}%")
            //       ->orWhere('note', 'LIKE', "%{$search}%");
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('visit_date', [$startDate, $endDate]);
        }
        return view('patientreport.pendingreports', [
            'query' => $query->paginate(25),
            'providers' => $providers,
            'doctors' => $doctors,
        ]);
    }

    // patient rejected reports
    public function rejectedReports(Request $request)
    {
        $providers = Provider::get();
        $doctors = Doctor::get();
        // $query = PatientReport::where('status', 3)->orderBy('created_at', 'desc');
        $query = PatientReport::whereHas('patient', function ($query) {
            $query->whereNull('deleted_at');
        })->where('status', 3)->orderBy('created_at', 'desc');

        if ($request->filled('provider')) {
            $query->where('provider_id', $request->input('provider'));
        }
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->input('doctor'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $patientIds = Patient::where('last_name', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->pluck('id');

            $query->whereIn('patient_id', $patientIds);

            // $query->orWhere('document_type', 'LIKE', "%{$search}%")
            //       ->orWhere('note', 'LIKE', "%{$search}%");
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('visit_date', [$startDate, $endDate]);
        }
        return view('patientreport.rejectreports', [
            'query' => $query->paginate(25),
            'providers' => $providers,
            'doctors' => $doctors,
        ]);
    }

    // patient fix reports
    public function fixReports(Request $request)
    {
        $providers = Provider::get();
        $doctors = Doctor::get();
        // $query = PatientReport::where('status', 4)->orderBy('created_at', 'desc');
        $query = PatientReport::whereHas('patient', function ($query) {
            $query->whereNull('deleted_at');
        })->where('status', 4)->orderBy('created_at', 'desc');

        if ($request->filled('provider')) {
            $query->where('provider_id', $request->input('provider'));
        }
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->input('doctor'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $patientIds = Patient::where('last_name', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->pluck('id');

            $query->whereIn('patient_id', $patientIds);

            // $query->orWhere('document_type', 'LIKE', "%{$search}%")
            //       ->orWhere('note', 'LIKE', "%{$search}%");
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('visit_date', [$startDate, $endDate]);
        }
        return view('patientreport.fixreports', [
            'query' => $query->paginate(25),
            'providers' => $providers,
            'doctors' => $doctors,
        ]);
    }

    // change reports status
    public function changeStatusReports(Request $request)
    {
        if ($request->ids != null) {
            $changeStatus = PatientReport::whereIn('id', $request->ids)->update([
                'status' => $request->status,
            ]);
            return redirect()->back()->with('success');
        } else {
            return redirect()->back()->with('error');
        }
    }

    // patient report download
    public function patientReportDownload($id)
    {
        $patientReport = PatientReport::findOrFail($id);

        if ($patientReport) {
            return Storage::download($patientReport->file_path);
        }
    }

    // patient report date update
    public function patientReportUpdateDate(Request $request)
    {

        $updateDate = PatientReport::where('id', $request->id)->update([
            'visit_date' => $request->date,
        ]);

        return redirect()->back()->with('success');
    }

    // patient report note update
    public function patientReportUpdateNote(Request $request)
    {

        $updateNote = PatientReport::where('id', $request->id)->update([
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success');
    }

    // ajax patient report date
    public function patientReportGetDate($id)
    {
        $reportDate = PatientReport::findOrFail($id);

        return response()->json([
            'id' => $reportDate->id,
            'date' => $reportDate->visit_date
        ]);
    }

    // ajax patient report note
    public function patientReportGetNote($id)
    {
        $reportNote = PatientReport::findOrFail($id);

        return response()->json([
            'id' => $reportNote->id,
            'note' => $reportNote->note
        ]);
    }
}
