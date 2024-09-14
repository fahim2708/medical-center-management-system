<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\OnlyOfficeController;
use App\Http\Controllers\ProviderDocumentsController;
use App\Http\Controllers\PatientReportsController;
use App\Http\Controllers\UrgentNotificationController;
use App\Models\PatientReport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;



Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'create']);

Route::group(['middleware' => 'auth'], function () {
    //Auth Routes
    Route::get('/', [PatientController::class, 'index'])->name('home');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'create']);
    Route::post('/logout', [LogoutController::class, 'index'])->name('logout');
    //User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update']);
    //Patient
    Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/patient/store', [PatientController::class, 'store'])->name('patient.store');
    Route::get('/patient/edit/{id}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/patient/update/{id}', [PatientController::class, 'update']);
    Route::get('/patient/delete/{id}', [PatientController::class, 'delete'])->name('patient.delete');


    // provider attach doctor
    Route::get('/attach_provider_to_doctor_list', [ProviderController::class, 'attachProviderToDoctorList'])->name('attach_provider_to_doctor_list');
    Route::get('/attach_provider_to_doctor', [ProviderController::class, 'attachProviderToDoctor'])->name('attach_provider_to_doctor');
    Route::post('/attach_provider_to_doctor/store', [ProviderController::class, 'attachProviderToDoctorStore'])->name('attach_provider_to_doctor.store');

    // ajax doctor fetch
    Route::get('/get_doctors/{provider}', [ProviderController::class, 'getDoctors'])->name('get_doctors');

    // doctor attach patient
    Route::get('/attach_doctor_to_patient', [DoctorController::class, 'attachDoctorToPatient'])->name('attach_doctor_to_patient');
    Route::post('/attach_doctor_to_patient/store', [DoctorController::class, 'attachDoctorToPatientStore'])->name('attach_doctor_to_patient.store');

    // ajax Patient fetch
    Route::get('/get_patients/{doctor}', [DoctorController::class, 'getPatient'])->name('get_patients');

    // provider view
    Route::get('/view/{providerId}/{doctorId}', [ProviderDocumentsController::class, 'providerView'])->name('provider.view');
    // folder
    Route::post('/provider/folder', [ProviderDocumentsController::class, 'providerFolderInsert'])->name('provider.folderinsert');
    Route::get('/provider/folder/delete/{id}', [ProviderDocumentsController::class, 'providerFolderDelete'])->name('provider.folderdelete');
    Route::post('/provider/folder/bulkdelete', [ProviderDocumentsController::class, 'providerFolderBulkDelete'])->name('provider.folderbulkdelete');
    // file
    Route::post('/provider/fileinsert', [ProviderDocumentsController::class, 'providerFileInsert'])->name('provider.fileinsert');
    Route::get('/provider/filedownload/{id}', [ProviderDocumentsController::class, 'providerFileDownload'])->name('provider.filedownload');
    Route::get('/provider/fileopen/{id}', [ProviderDocumentsController::class, 'providerFileOpen'])->name('provider.fileopen');
    Route::get('/provider/filedelete/{id}', [ProviderDocumentsController::class, 'providerFileDelete'])->name('provider.filedelete');
    Route::post('/provider/bulkfiledownload', [ProviderDocumentsController::class, 'providerBulkFileDownload'])->name('provider.bulkfiledownload');
    Route::post('/provider/bulkfiledelete', [ProviderDocumentsController::class, 'providerBulkFileDelete'])->name('provider.bulkfiledelete');
    Route::get('/provider/file/urgent/{id}', [ProviderDocumentsController::class, 'providerFileUrgent'])->name('provider.fileurgent');
    Route::get('/provider/file/removeurgent/{id}', [ProviderDocumentsController::class, 'providerFileRemoveUrgent'])->name('provider.fileremoveurgent');
    Route::get('/search-reports', [ProviderDocumentsController::class, 'searchReports'])->name('reports.search');
    // ajax get report table
    Route::post('/provider/getreports', [ProviderDocumentsController::class, 'providerFileReports'])->name('provider.filereports');
    // ajax file favourite
    Route::get('/provider/filefavourite/{id}', [ProviderDocumentsController::class, 'providerFileFavourite'])->name('provider.filefavourite');
    // ajax get file name
    Route::get('/provider/ajax_name/{id}', [ProviderDocumentsController::class, 'providerFileGetName'])->name('provider.ajax_name');
    // provider file update name
    Route::post('/provider/file/update/name', [ProviderDocumentsController::class, 'providerFileUpdateName'])->name('provider.fileupdatename');

    // patient view
    Route::get('/patient/view/{id}', [PatientReportsController::class, 'patientView'])->name('patient.view');
    Route::post('/patient/report/submit', [PatientReportsController::class, 'patientReportsubmit'])->name('patient.reportsubmit');
    Route::get('/patient/report/download/{id}', [PatientReportsController::class, 'patientReportDownload'])->name('patient.reportdownload');
    Route::get('/patient/report/delete/{id}', [PatientReportsController::class, 'patientReportDelete'])->name('patient.reportdelete');
    Route::post('/patient/report/bulkdelete', [PatientReportsController::class, 'patientReportBulkdelete'])->name('patient.reportbulkdelete');
    Route::post('/patient/report/bulkdownlaod', [PatientReportsController::class, 'patientReportBulkdownlaod'])->name('patient.reportbulkdownlaod');

    // patient report on status based
    Route::get('/patient/report/aprroved', [PatientReportsController::class, 'approvedReports'])->name('patient.approvereports');
    Route::get('/patient/report/pending', [PatientReportsController::class, 'pendingReports'])->name('patient.pendingreports');
    Route::get('/patient/report/rejected', [PatientReportsController::class, 'rejectedReports'])->name('patient.rejectedreports');
    Route::get('/patient/report/fix', [PatientReportsController::class, 'fixReports'])->name('patient.fixreports');
    Route::post('/patient/report/changestatus', [PatientReportsController::class, 'changeStatusReports'])->name('patient.changestatusreport');

    // patient update date
    Route::post('/patient/report/update/date', [PatientReportsController::class, 'patientReportUpdateDate'])->name('patient.reportupdatedate');
    Route::post('/patient/report/update/note', [PatientReportsController::class, 'patientReportUpdateNote'])->name('patient.reportupdatenote');

    // ajax patient report routes
    Route::get('/patient/ajax_date/{id}', [PatientReportsController::class, 'patientReportGetDate'])->name('patient.ajax_date');
    Route::get('/patient/ajax_note/{id}', [PatientReportsController::class, 'patientReportGetNote'])->name('patient.ajax_note');


    Route::get('/onlyoffice/open/{id}', [OnlyOfficeController::class, 'openDocument'])->name('onlyoffice.open');
    Route::post('/onlyoffice/callback/{id}', [OnlyOfficeController::class, 'callback'])->name('onlyoffice.callback');
    Route::get('/documents/{id}', function ($id) {
        // Retrieve the document from the database
        $document = PatientReport::findOrFail($id);

        // Construct the file path - assuming the files are stored in 'storage/app/documents'
        $filePath = 'patientDocuments/' . $document->file_name;

        // Check if the file exists
        if (!Storage::exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Get the file's contents
        $fileContents = Storage::get($filePath);

        // Return the file as a response
        return Response::make($fileContents, 200, [
            'Content-Type' => Storage::mimeType($filePath),
            'Content-Disposition' => 'inline; filename="'. $document->file_name .'"'
        ]);
    })->name('documents.show');

    // new provider document menu 
    Route::get('/search/doctors/{providerId}', [DoctorController::class, 'searchDoctors']);
    Route::get('/provider/{providerId}/doctors/initial', [DoctorController::class, 'initialDoctors']);
    // new provider document menu 


    // Route::get('edit-document/{id}', [DocumentController::class, 'edit'])->name('document.edit');
    // Route::post('save-document/{id}',  [DocumentController::class, 'save'])->name('document.save');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('/urgent-notifications', [UrgentNotificationController::class, 'index'])->name('u-notifications.index');
    Route::post('/urgent-notifications/{notification}/read', [UrgentNotificationController::class, 'markAsRead'])->name('u-notifications.read');
});
