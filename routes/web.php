<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});






//portal routes
Route::prefix('portal')->group(function() {
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/invoice', 'InvoiceController@index');
    Route::any('/invoice/list', 'InvoiceController@get_invoices');
    Route::any('/invoice/invoice_model', 'InvoiceController@add_invoice_modal');
    
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home/add_appoiment_model/{aid?}', 'HomeController@add_appoiment_model');
    
    Route::post('/home/add_appointment', 'HomeController@add_appointment');
    Route::get('/home/get_appointment/{id?}', 'HomeController@get_appointment');
    Route::post('/home/delete_appointment/{id}', 'HomeController@delete_appointment');
    
    Route::get('patient', 'PatientController@index');
    Route::get('patient/lists', 'PatientController@patient_list');
    Route::get('patient/setup', 'PatientController@setup');
    Route::get('patient/setup/{patientId}', 'PatientController@setup');
    Route::get('patient/view', 'PatientController@view');
    Route::get('patient/view/{patientId}', 'PatientController@view');
    Route::get('patient/patient_setup', 'PatientController@patient_setup');
    Route::post('patient/commit', 'PatientController@commit');
    Route::post('patient/save_general_detail', 'PatientController@save_general_detail');
    Route::post('patient/save_contact_detail', 'PatientController@save_contact_detail');
    Route::get('patient/delete_patient/{id}', 'PatientController@delete_patient');
    Route::any('patient/report/{id}', 'PatientController@report');
    Route::any('patient/invoice/{id}', 'PatientController@invoice');
    Route::post('patient/report_upload/{id}', 'PatientController@report_upload');
    Route::get('patient/detete_report/{id}', 'PatientController@detete_report');
    Route::post('patient/add_extra_notes', 'PatientController@add_extra_notes');
    Route::post('patient/get_extra_notes/{id}', 'PatientController@get_extra_notes');
    Route::post('patient/delete_extra_notes/{id}', 'PatientController@delete_extra_notes');
//    Route::post('patient/view_card/{id}', 'PatientController@view_card');
    Route::post('patient/patient_card/{id}', 'PatientController@patient_card');
    Route::post('patient/add_notes', 'PatientController@add_notes');
    Route::post('patient/note_model/{pid}/{id?}', 'PatientController@note_model');
    Route::post('patient/get_notes/{id?}', 'PatientController@get_notes');
    Route::post('patient/delete_notes/{pid}/{id}', 'PatientController@delete_notes');
    Route::any('patient/invoice_report/{id}', 'PatientController@invoice_report');
    Route::get('patient/get_ajax_invoice/{id}', 'PatientController@get_ajax_invoice');

    
    
    Route::get('prescription', 'CertificatesController@index');
    Route::get('prescription/setup', 'CertificatesController@prescription_setup');
    Route::get('prescription/setup/{id}', 'CertificatesController@prescription_setup');
    Route::post('prescription/prescription_commit', 'CertificatesController@prescription_commit');
    Route::get('prescription/prescription_lists', 'CertificatesController@prescription_list');
    Route::get('prescription/delete_prescription/{id}', 'CertificatesController@delete_prescription');
    
    Route::any('certificate/{report_type?}', 'CertificatesController@index');
    Route::get('certificate/setup/{report_type}/{id?}', 'CertificatesController@setup');
    Route::post('certificate/commit/{report_type}', 'CertificatesController@commit');
    Route::get('certificate/delete/{report_type}/{id?}', 'CertificatesController@delete');

    
    Route::get('tool', 'ToolsController@index');
    Route::post('tool/commit', 'ToolsController@commit');
    Route::post('tool/delete', 'ToolsController@delete');
    Route::post('tool/tool_data', 'ToolsController@tool_data');

    Route::get('investigation', 'InvestigationController@index');
    Route::post('investigation/commit', 'InvestigationController@commit');
    Route::post('investigation/delete', 'InvestigationController@delete');
    Route::post('investigation/tool_data', 'InvestigationController@tool_data');
    
    Route::get('listpatient', 'PatientController@patientlist');
    Route::get('getpatient', 'PatientController@getpatientlist');
    Route::get('patient/search_patient', 'PatientController@search_patient');
    
    Route::get('master','MasterController@index');
    Route::any('master/list', 'MasterController@get_list');
    Route::get('master/setup/{id?}','MasterController@setup');
    Route::post('master/commit','MasterController@commit');
    Route::get('master/delete/{id?}', 'MasterController@delete');
    
    Route::get('receptionist','ReceptionistController@index');
    Route::any('receptionist/list', 'ReceptionistController@get_list');
    Route::get('receptionist/setup/{id?}','ReceptionistController@setup');
    Route::post('receptionist/commit','ReceptionistController@commit');
    Route::get('receptionist/delete/{id?}', 'ReceptionistController@delete');
    
    Route::get('doctor','DoctorController@index');
    Route::any('doctor/list', 'DoctorController@get_list');
    Route::get('doctor/setup/{id?}','DoctorController@setup');
    Route::post('doctor/commit','DoctorController@commit');
    Route::get('doctor/delete/{id?}', 'DoctorController@delete');
    
});

///Route::get('/home', 'HomeController@index')->name('home');
