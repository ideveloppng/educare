<?php

use Illuminate\Support\Facades\Route;

/* --- Core & Shared Controllers --- */
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/* --- Public / Guest Controllers --- */
use App\Http\Controllers\Public\RegistrationController;
use App\Http\Controllers\Public\SchoolOnboardingController;

/* --- Super Admin Controllers (System Owner) --- */
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\AdminUserController;
use App\Http\Controllers\SuperAdmin\BankDetailController;
use App\Http\Controllers\SuperAdmin\SupportController as SuperSupportController;

/* --- School Admin Controllers (Institutional Manager) --- */
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\TeacherAssignmentController as WorkloadController;
use App\Http\Controllers\Admin\ResultTokenController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\SupportController as AdminSupportController;

/* --- Teacher Controllers --- */
use App\Http\Controllers\Teacher\AssignmentController as TeacherTaskController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\MarksController;
use App\Http\Controllers\Teacher\ClassController as TeacherClassController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\TimetableController as TeacherTimetableController;

/* --- Student Controllers --- */
use App\Http\Controllers\Student\AssignmentController as StudentTaskController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Student\FeeController;
use App\Http\Controllers\Student\TeacherDirectoryController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\TimetableController as StudentTimetableController;

/* --- Parent Controllers --- */
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Parent\ChildController;
use App\Http\Controllers\Parent\ResultController as ParentResultController;
use App\Http\Controllers\Parent\FeeController as ParentFeeController;
use App\Http\Controllers\Parent\ProfileController as ParentProfileController;

/* --- Accountant Controllers --- */
use App\Http\Controllers\Accountant\AccountantDashboardController;
use App\Http\Controllers\Accountant\FeeCollectionController;
use App\Http\Controllers\Accountant\LedgerController;
use App\Http\Controllers\Accountant\PayrollController;
use App\Http\Controllers\Accountant\ClassFeeController as AccountantClassFeeController;
use App\Http\Controllers\Accountant\ProfileController as AccountantProfileController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Accessible to everyone)
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return redirect()->route('login'); });

// School Self-Onboarding
Route::get('/register-school', [SchoolOnboardingController::class, 'showForm'])->name('public.school.register');
Route::post('/register-school', [SchoolOnboardingController::class, 'store'])->name('public.school.store');

// Individual Role Self-Registration (Links from Settings)
Route::get('/register/{role}/{key}', [RegistrationController::class, 'showForm'])->name('public.register');
Route::post('/register/{role}/{key}', [RegistrationController::class, 'store'])->name('public.register.store');

/*
|--------------------------------------------------------------------------
| 2. SHARED AUTHENTICATED ROUTES (No Subscription Check)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/billing', function () { return view('billing.index'); })->name('billing.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| 3. SUPER ADMIN ROUTES (System Management)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('super_admin.dashboard');
    
    // School & Plan Management
    Route::resource('schools', SchoolController::class);
    Route::patch('/schools/{school}/toggle', [SchoolController::class, 'toggleStatus'])->name('schools.toggle');
    Route::resource('plans', PlanController::class)->names('super_admin.plans');
    
    // Revenue & Payment Verification
    Route::get('/payments', [PaymentController::class, 'index'])->name('super_admin.payments.index');
    Route::patch('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('super_admin.payments.update');
    
    // Master User Control
    Route::get('/school-admins', [AdminUserController::class, 'index'])->name('super_admin.admins.index');
    Route::put('/school-admins/{user}', [AdminUserController::class, 'update'])->name('super_admin.admins.update');
    Route::patch('/school-admins/{user}/password', [AdminUserController::class, 'resetPassword'])->name('super_admin.admins.password');

    // Receiving Bank Details Setup
    Route::post('/bank-details', [BankDetailController::class, 'store'])->name('super_admin.banks.store');
    Route::put('/bank-details/{bank}', [BankDetailController::class, 'update'])->name('super_admin.banks.update');
    Route::delete('/bank-details/{bank}', [BankDetailController::class, 'destroy'])->name('super_admin.banks.destroy');
    Route::patch('/bank-details/{bank}/toggle', [BankDetailController::class, 'toggle'])->name('super_admin.banks.toggle');

    // Help Center Configuration
    Route::resource('support', SuperSupportController::class)->names('super_admin.support');
});

/*
|--------------------------------------------------------------------------
| 4. SCHOOL PORTAL ROUTES (Guarded by Subscription)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'check.subscription'])->group(function () {

    // Global Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* --- SCHOOL ADMIN (Manager) --- */
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Registry
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students');
        Route::resource('students', AdminStudentController::class)->except(['index']);
        Route::patch('/students/{student}/toggle', [AdminStudentController::class, 'toggleStatus'])->name('students.toggle');
        
        Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('teachers');
        Route::resource('teachers', AdminTeacherController::class)->except(['index']);
        Route::patch('/teachers/{teacher}/toggle', [AdminTeacherController::class, 'toggleStatus'])->name('teachers.toggle');

        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/register', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff/register', [StaffController::class, 'store'])->name('staff.store');
        
        // Academic Mapping
        Route::get('/classes', [ClassController::class, 'index'])->name('classes');
        Route::resource('classes', ClassController::class)->except(['index']);
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects');
        Route::resource('subjects', SubjectController::class)->except(['index']);
        Route::get('/teachers-assignments', [WorkloadController::class, 'index'])->name('teachers.assignments');
        Route::post('/teachers-assignments', [WorkloadController::class, 'store'])->name('teachers.assignments.store');
        Route::delete('/teachers-assignments/{assignment}', [WorkloadController::class, 'destroy'])->name('teachers.assignments.destroy');

        // Timetables
        Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables');
        Route::get('/timetables/manage/{class}', [TimetableController::class, 'manage'])->name('timetables.manage');
        Route::post('/timetables/store', [TimetableController::class, 'store'])->name('timetables.store');
        Route::put('/timetables/{timetable}', [TimetableController::class, 'update'])->name('timetables.update');
        Route::delete('/timetables/{timetable}', [TimetableController::class, 'destroy'])->name('timetables.destroy');
        Route::get('/timetables/print/{class}', [TimetableController::class, 'print'])->name('timetables.print');

        // Result Management
        Route::get('/result-tokens', [ResultTokenController::class, 'index'])->name('tokens');
        Route::post('/result-tokens/generate', [ResultTokenController::class, 'generate'])->name('tokens.generate');
        Route::get('/result-tokens/print', [ResultTokenController::class, 'print'])->name('tokens.print');
        Route::post('/marks/publish/{class}/{subject}', [MarksController::class, 'publish'])->name('marks.publish');

        // Finance (Admin Level)
        Route::prefix('finance')->group(function () {
            Route::get('/', [FinanceController::class, 'index'])->name('finance'); 
            Route::name('finance.')->group(function() {
                Route::get('/class-fees', [FinanceController::class, 'classFees'])->name('fees');
                Route::get('/class-fees/{class}', [FinanceController::class, 'showFees'])->name('fees.show');
                Route::post('/class-fees/store', [FinanceController::class, 'storeFee'])->name('fees.store');
                Route::put('/class-fees/{fee}', [FinanceController::class, 'updateFeeItem'])->name('fees.update_item');
                Route::delete('/class-fees/{fee}', [FinanceController::class, 'destroyFee'])->name('fees.destroy');
                Route::get('/general-ledger', [FinanceController::class, 'ledger'])->name('ledger');
                Route::get('/payroll', [FinanceController::class, 'payroll'])->name('payroll');
            });
        });

        // Parents & Settings
        Route::get('/parents', [ParentController::class, 'index'])->name('parents');
        Route::resource('parents', ParentController::class)->except(['index']);
        Route::post('/parents/{parent}/link', [ParentController::class, 'linkStudent'])->name('parents.link');
        Route::get('/linking-requests', [ParentController::class, 'showRequests'])->name('parents.requests');
        Route::post('/linking-requests/{id}/process', [ParentController::class, 'processRequest'])->name('parents.requests.process');
        
        Route::get('/notice-board', [NoticeController::class, 'index'])->name('noticeboard');
        Route::resource('noticeboard', NoticeController::class)->except(['index']);
        
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::patch('/settings/academic', [SettingsController::class, 'updateAcademic'])->name('settings.academic.update');
        Route::patch('/settings/registration-status', [SettingsController::class, 'updateRegStatus'])->name('settings.reg_status.update');
        Route::post('/settings/bank', [SettingsController::class, 'storeBank'])->name('settings.bank.store');
        Route::patch('/settings/bank/{bank}/toggle', [SettingsController::class, 'toggleBank'])->name('settings.bank.toggle');
        Route::delete('/settings/bank/{bank}', [SettingsController::class, 'destroyBank'])->name('settings.bank.delete');
        
        // Subscription & Support
        Route::get('/my-subscription', [App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('/my-subscription/pay', [App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('subscription.store');
        Route::get('/help-center', [AdminSupportController::class, 'index'])->name('support');
    });

    /* --- TEACHER PERSONA --- */
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/assignments', [TeacherTaskController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/create', [TeacherTaskController::class, 'create'])->name('assignments.create');
        Route::post('/assignments/store', [TeacherTaskController::class, 'store'])->name('assignments.store');
        Route::get('/assignments/{assignment}/submissions', [TeacherTaskController::class, 'submissions'])->name('assignments.submissions');
        Route::post('/submissions/{submission}/grade', [TeacherTaskController::class, 'grade'])->name('assignments.grade');
        
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/take/{class}', [AttendanceController::class, 'take'])->name('attendance.take');
        Route::post('/attendance/store/{class}', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/history/{class}', [AttendanceController::class, 'history'])->name('attendance.history');
        Route::get('/attendance/print/{class}', [AttendanceController::class, 'print'])->name('attendance.print');

        Route::get('/marks', [MarksController::class, 'index'])->name('marks.index');
        Route::get('/marks/entry/{class}/{subject}', [MarksController::class, 'entry'])->name('marks.entry');
        Route::post('/marks/store/{class}/{subject}', [MarksController::class, 'store'])->name('marks.store');
        
        //Add teacher.marks.publish route
        Route::post('/marks/publish/{class}/{subject}', [MarksController::class, 'publish'])->name('marks.publish');

        Route::get('/my-timetable', [TeacherTimetableController::class, 'index'])->name('timetable.index');
        Route::get('/classes', [TeacherClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/{class}', [TeacherClassController::class, 'show'])->name('classes.show');
        Route::get('/profile', [TeacherProfileController::class, 'index'])->name('profile.index');
        Route::patch('/profile/update', [TeacherProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [TeacherProfileController::class, 'updatePassword'])->name('profile.password');
    });

    /* --- STUDENT PERSONA --- */
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile');
        Route::patch('/profile/update', [StudentProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
        Route::get('/assignments', [StudentTaskController::class, 'index'])->name('assignments');
        Route::post('/assignments/{assignment}/submit', [StudentTaskController::class, 'submit'])->name('assignments.submit');
        Route::get('/check-result', [ResultController::class, 'index'])->name('results');
        Route::post('/check-result', [ResultController::class, 'check'])->name('results.check');
        Route::get('/report-card/{token}', [ResultController::class, 'show'])->name('results.show');
        Route::get('/my-fees', [FeeController::class, 'index'])->name('fees');
        Route::get('/my-fees/pay', [FeeController::class, 'pay'])->name('fees.pay');
        Route::post('/my-fees/pay', [FeeController::class, 'submitPayment'])->name('fees.submit');
        Route::get('/my-teachers', [TeacherDirectoryController::class, 'index'])->name('teachers');
        Route::get('/my-timetable', [StudentTimetableController::class, 'index'])->name('timetable');
    });

    /* --- PARENT PERSONA --- */
    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-children', [ChildController::class, 'index'])->name('children');
        Route::post('/my-children/request', [ChildController::class, 'requestLink'])->name('children.request');
        Route::get('/family-fees', [ParentFeeController::class, 'index'])->name('fees');
        Route::get('/family-fees/pay/{student}', [ParentFeeController::class, 'pay'])->name('fees.pay');
        Route::post('/family-fees/pay/{student}', [ParentFeeController::class, 'submitPayment'])->name('fees.submit');
        Route::get('/results', [ParentResultController::class, 'index'])->name('results');
        Route::get('/results/check/{student}', [ParentResultController::class, 'gateway'])->name('results.gateway');
        Route::post('/results/check/{student}', [ParentResultController::class, 'check'])->name('results.check');
        Route::get('/results/view/{student}/{token}', [ParentResultController::class, 'show'])->name('results.show');
        Route::get('/my-profile', [ParentProfileController::class, 'index'])->name('profile');
        Route::patch('/my-profile/update', [ParentProfileController::class, 'update'])->name('profile.update');
        Route::patch('/my-profile/password', [ParentProfileController::class, 'updatePassword'])->name('profile.password');
    });
    
    /* --- ACCOUNTANT PERSONA --- */
    Route::prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', [AccountantDashboardController::class, 'index'])->name('dashboard');
        Route::get('/collections', [FeeCollectionController::class, 'index'])->name('collections');
        Route::patch('/collections/{payment}/verify', [FeeCollectionController::class, 'verify'])->name('collections.verify');
        Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger');
        Route::post('/ledger/store', [LedgerController::class, 'store'])->name('ledger.store');
        Route::delete('/ledger/{transaction}', [LedgerController::class, 'destroy'])->name('ledger.destroy');
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll');
        Route::post('/payroll/process', [PayrollController::class, 'process'])->name('payroll.process');
        Route::get('/payroll/{payroll}/print', [PayrollController::class, 'print'])->name('payroll.print');
        Route::get('/fees-setup', [AccountantClassFeeController::class, 'index'])->name('fees');
        Route::get('/profile', [AccountantProfileController::class, 'index'])->name('profile');
        Route::patch('/profile/update', [AccountantProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [AccountantProfileController::class, 'updatePassword'])->name('profile.password');
    });

});

/* --- Authentication Logic (Laravel Breeze) --- */
require __DIR__.'/auth.php';