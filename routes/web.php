<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\ParentDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// AUTH ROUTES
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.store')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// PUBLIC ROUTES
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/ppdb', [PublicController::class, 'ppdb'])->name('ppdb');
Route::post('/ppdb', [PPDBController::class, 'store'])->name('ppdb.store');
Route::get('/kegiatan', [PublicController::class, 'kegiatan'])->name('kegiatan');
Route::get('/kegiatan/{id}', [PublicController::class, 'showActivity'])->name('kegiatan.show');
Route::get('/program', [PublicController::class, 'program'])->name('program');
Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [PublicController::class, 'sendContact'])->name('kontak.send');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/informasi', [PublicController::class, 'informasi'])->name('informasi');
Route::get('/informasi/{tipe}', [PublicController::class, 'getInformasi'])->name('informasi.tipe');

// DEMO ROUTES - Remove these before production (for testing without authentication)
Route::get('/admin/demo-dashboard', [AdminController::class, 'dashboard'])->name('admin-demo.dashboard');
Route::get('/admin/demo-ppdb', [AdminController::class, 'ppdbIndex'])->name('admin-demo.ppdb.index');
Route::get('/admin/demo-program', [AdminController::class, 'programIndex'])->name('admin-demo.program.index');
Route::get('/admin/demo-activity', [AdminController::class, 'activityIndex'])->name('admin-demo.activity.index');
Route::get('/admin/demo-announcement', [AdminController::class, 'announcementIndex'])->name('admin-demo.announcement.index');
Route::get('/admin/demo-faq', [AdminController::class, 'faqIndex'])->name('admin-demo.faq.index');

// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // PPDB Management
    Route::get('/ppdb', [AdminController::class, 'ppdbIndex'])->name('ppdb.index');
    Route::get('/ppdb/{id}', [AdminController::class, 'ppdbShow'])->whereNumber('id')->name('ppdb.show');
    Route::patch('/ppdb/{id}/status/{status}', [AdminController::class, 'ppdbUpdateStatus'])->name('ppdb.updateStatus');
    Route::get('/ppdb/export/excel', [AdminController::class, 'ppdbExportExcel'])->name('ppdb.export.excel');
    Route::get('/ppdb/export/pdf', [AdminController::class, 'ppdbExportPdf'])->name('ppdb.export.pdf');

    // Program Management

    Route::get('/program', [AdminController::class, 'programIndex'])->name('program.index');
    Route::get('/program/create', [AdminController::class, 'programCreate'])->name('program.create');
    Route::post('/program', [AdminController::class, 'programStore'])->name('program.store');
    Route::get('/program/{id}/edit', [AdminController::class, 'programEdit'])->name('program.edit');
    Route::put('/program/{id}', [AdminController::class, 'programUpdate'])->name('program.update');
    Route::delete('/program/{id}', [AdminController::class, 'programDestroy'])->name('program.destroy');

    // Activity Management
    Route::get('/activity', [AdminController::class, 'activityIndex'])->name('activity.index');
    Route::get('/activity/create', [AdminController::class, 'activityCreate'])->name('activity.create');
    Route::post('/activity', [AdminController::class, 'activityStore'])->name('activity.store');
    Route::get('/activity/update-descriptions', [AdminController::class, 'activityUpdateDescriptions'])->name('activity.update.descriptions');
    Route::get('/activity/{id}/edit', [AdminController::class, 'activityEdit'])->name('activity.edit');
    Route::put('/activity/{id}', [AdminController::class, 'activityUpdate'])->name('activity.update');
    Route::delete('/activity/{id}', [AdminController::class, 'activityDestroy'])->name('activity.destroy');

    // Announcement Management
    Route::get('/announcement', [AdminController::class, 'announcementIndex'])->name('announcement.index');
    Route::get('/announcement/create', [AdminController::class, 'announcementCreate'])->name('announcement.create');
    Route::post('/announcement', [AdminController::class, 'announcementStore'])->name('announcement.store');
    Route::get('/announcement/{id}/edit', [AdminController::class, 'announcementEdit'])->name('announcement.edit');
    Route::put('/announcement/{id}', [AdminController::class, 'announcementUpdate'])->name('announcement.update');
    Route::delete('/announcement/{id}', [AdminController::class, 'announcementDestroy'])->name('announcement.destroy');

    // FAQ Management
    Route::get('/faq', [AdminController::class, 'faqIndex'])->name('faq.index');
    Route::get('/faq/create', [AdminController::class, 'faqCreate'])->name('faq.create');
    Route::post('/faq', [AdminController::class, 'faqStore'])->name('faq.store');
    Route::get('/faq/{id}/edit', [AdminController::class, 'faqEdit'])->name('faq.edit');
    Route::put('/faq/{id}', [AdminController::class, 'faqUpdate'])->name('faq.update');
    Route::delete('/faq/{id}', [AdminController::class, 'faqDestroy'])->name('faq.destroy');

    // PPDB Settings Management
    Route::get('/ppdb-settings', [AdminController::class, 'ppdbSettingsEdit'])->name('ppdb.settings');
    Route::put('/ppdb-settings', [AdminController::class, 'ppdbSettingsUpdate'])->name('ppdb.settings.update');

    // Archive routes (User & PPDB)
    Route::get('/users/archive', [AdminController::class, 'usersArchiveIndex'])->name('users.archive');
    Route::post('/users/{id}/archive', [AdminController::class, 'usersArchive'])->name('users.archive.store');
    Route::post('/users/{id}/restore', [AdminController::class, 'usersRestore'])->name('users.restore');

    Route::get('/ppdb/archive', [AdminController::class, 'ppdbArchiveIndex'])->name('ppdb.archive');
    Route::post('/ppdb/archive-year', [AdminController::class, 'ppdbArchiveByYear'])->name('ppdb.archive.year');
    Route::post('/ppdb/{id}/archive', [AdminController::class, 'ppdbArchive'])->name('ppdb.archive.store');
    Route::post('/ppdb/{id}/restore', [AdminController::class, 'ppdbRestore'])->name('ppdb.restore');
    // School Info Management
    Route::get('/school-info/edit', [AdminController::class, 'schoolInfoEdit'])->name('school-info.edit');
    Route::put('/school-info', [AdminController::class, 'schoolInfoUpdate'])->name('school-info.update');

    // Teacher Schedule Management (Monitoring Dashboard)
    Route::prefix('schedule/teacher')->name('schedule.teacher.')->group(function () {
        Route::get('/', [AdminController::class, 'scheduleTeacherIndex'])->name('index');
        Route::get('/{id}', [AdminController::class, 'scheduleTeacherShow'])->name('show');
    });

    // Student Schedule Management (wizard for creating new schedules)
    Route::prefix('schedule/student')->name('schedule.student.')->group(function () {
        Route::get('/', [AdminController::class, 'scheduleStudentIndex'])->name('index');
        // Wizard steps for creating/importing schedules
        Route::get('/wizard/step-1', [AdminController::class, 'scheduleStudentWizardStep1'])->name('wizard.step1');
        Route::post('/wizard/step-1', [AdminController::class, 'scheduleStudentWizardStoreStep1'])->name('wizard.step1.store');

        Route::get('/wizard/step-2', [AdminController::class, 'scheduleStudentWizardStep2'])->name('wizard.step2');
        Route::post('/wizard/step-2', [AdminController::class, 'scheduleStudentWizardStoreStep2'])->name('wizard.step2.store');

        Route::get('/wizard/step-3', [AdminController::class, 'scheduleStudentWizardStep3'])->name('wizard.step3');

        Route::post('/wizard/item/{index}/update', [AdminController::class, 'scheduleStudentWizardUpdateItem'])->whereNumber('index')->name('wizard.item.update');
        Route::post('/wizard/item/{index}/delete', [AdminController::class, 'scheduleStudentWizardDeleteItem'])->whereNumber('index')->name('wizard.item.delete');

        Route::post('/wizard/publish', [AdminController::class, 'scheduleStudentPublish'])->name('wizard.publish');

        // Keep existing CRUD for listing/editing/deleting legacy student schedules
        Route::post('/', [AdminController::class, 'scheduleStudentStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'scheduleStudentEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'scheduleStudentUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'scheduleStudentDestroy'])->name('destroy');
    });

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'usersIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'usersCreate'])->name('create');
        Route::post('/', [AdminController::class, 'usersStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'usersEdit'])->name('edit');
        Route::get('/{id}/show', [AdminController::class, 'usersShow'])->name('show');
        Route::put('/{id}', [AdminController::class, 'usersUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'usersDelete'])->name('delete');
        Route::post('/{id}/reset-password', [AdminController::class, 'usersResetPassword'])->name('reset-password');

    Route::get('/download-template', [AdminController::class, 'usersDownloadTemplate'])->name('download-template');
    Route::post('/import', [AdminController::class, 'usersImport'])->name('import');
    Route::post('/validate-import', [AdminController::class, 'usersValidateImport'])->name('validate-import');
    Route::post('/process-import', [AdminController::class, 'usersProcessImport'])->name('process-import');
    });
});

// STUDENT ROUTES
Route::middleware(['auth', 'role:siswa'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Schedule
    Route::get('/schedule', [StudentDashboardController::class, 'schedule'])->name('schedule');

    // Grades
    Route::get('/grades', [StudentDashboardController::class, 'grades'])->name('grades');

    // Profile
    Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [StudentDashboardController::class, 'updateProfile'])->name('profile.update');

    // Password
    Route::get('/change-password', [StudentDashboardController::class, 'showChangePassword'])->name('change-password');
    Route::put('/change-password', [StudentDashboardController::class, 'updatePassword'])->name('change-password.update');

    // Photo
    Route::get('/upload-photo', [StudentDashboardController::class, 'showUploadPhoto'])->name('upload-photo');
    Route::post('/upload-photo', [StudentDashboardController::class, 'uploadPhoto'])->name('upload-photo.store');

    // Informasi, Kegiatan, Kontak
    Route::get('/informasi', [StudentDashboardController::class, 'informasi'])->name('informasi');
    Route::get('/kegiatan', [StudentDashboardController::class, 'kegiatan'])->name('kegiatan');
    Route::get('/kontak', [StudentDashboardController::class, 'kontak'])->name('kontak');
});

// TEACHER ROUTES
Route::middleware(['auth', 'role:guru'])->prefix('teacher')->name('teacher.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    // Schedule
    Route::get('/schedule', [TeacherDashboardController::class, 'schedule'])->name('schedule');
    // Import parsed schedule from uploaded DOCX (developer helper)
    Route::post('/schedule/import-parsed', [TeacherDashboardController::class, 'importParsedToDb'])->name('schedule.import_parsed');

    // Students
    Route::get('/students', [TeacherDashboardController::class, 'students'])->name('students');
    Route::get('/students/search', [TeacherDashboardController::class, 'searchStudents'])->name('students.search');
    Route::get('/students/{id}', [TeacherDashboardController::class, 'studentDetail'])->name('students.show');

    // Grades
    Route::get('/grades', [TeacherDashboardController::class, 'grades'])->name('grades');
    Route::get('/grades/{level}/{classSlug}', [TeacherDashboardController::class, 'gradeClassDetail'])
        ->whereIn('level', ['sd', 'smp', 'smk'])
        ->name('grades.detail');
    Route::get('/grades/edit/{id?}', [TeacherDashboardController::class, 'editGrade'])->name('grades.edit');
    Route::post('/grades', [TeacherDashboardController::class, 'storeGrade'])->name('grades.store');
    Route::put('/grades/{id}', [TeacherDashboardController::class, 'storeGrade'])->name('grades.update');
    Route::delete('/grades/{id}', [TeacherDashboardController::class, 'deleteGrade'])->name('grades.delete');
    Route::post('/grades/ajax/store', [TeacherDashboardController::class, 'storeGradeAjax'])->name('grades.ajax.store');
    Route::post('/grades/ajax/batch-save', [TeacherDashboardController::class, 'batchSaveGrades'])->name('grades.ajax.batch');
    Route::post('/grades/import', [TeacherDashboardController::class, 'importGrades'])->name('grades.import');
    Route::get('/grades/export', [TeacherDashboardController::class, 'exportGrades'])->name('grades.export');
    Route::get('/grades/export-excel', [TeacherDashboardController::class, 'exportGradesExcel'])->name('grades.export-excel');
    Route::get('/grades/export-proper', [TeacherDashboardController::class, 'exportGradesExcelProper'])->name('export-grades-excel');
    Route::get('/grades/students-by-class', [TeacherDashboardController::class, 'studentsByClass'])->name('grades.students-by-class');
    Route::get('/grades/{level}/{classSlug}/rekap', [TeacherDashboardController::class, 'rekapNilai'])
        ->whereIn('level', ['sd', 'smp', 'smk'])
        ->name('grades.rekap');


    // Reports
    Route::get('/report-summary', [TeacherDashboardController::class, 'getReportSummary'])->name('report-summary');
    Route::get('/report/export-excel', [TeacherDashboardController::class, 'exportGradesExcelProper'])->name('export-report-excel');
    Route::get('/report/export-pdf', [TeacherDashboardController::class, 'exportReportPDF'])->name('export-report-pdf');

    // Profile
    Route::get('/profile', [TeacherDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [TeacherDashboardController::class, 'updateProfile'])->name('profile.update');

    // Password
    Route::get('/change-password', [TeacherDashboardController::class, 'showChangePassword'])->name('change-password');
    Route::put('/change-password', [TeacherDashboardController::class, 'updatePassword'])->name('change-password.update');

    // Photo
    Route::get('/upload-photo', [TeacherDashboardController::class, 'showUploadPhoto'])->name('upload-photo');
    Route::post('/upload-photo', [TeacherDashboardController::class, 'uploadPhoto'])->name('upload-photo.store');

    // Informasi, Kegiatan, Kontak
    Route::get('/informasi', [TeacherDashboardController::class, 'informasi'])->name('informasi');
    Route::get('/kegiatan', [TeacherDashboardController::class, 'kegiatan'])->name('kegiatan');
    Route::get('/kontak', [TeacherDashboardController::class, 'kontak'])->name('kontak');
});

// PARENT ROUTES
Route::middleware(['auth', 'role:orangtua'])->prefix('parent')->name('parent.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');

    // Children
    Route::get('/children', [ParentDashboardController::class, 'children'])->name('children');
    Route::get('/children/{id}/details', [ParentDashboardController::class, 'childDetails'])->name('children.details');

    // Profile
    Route::get('/profile', [ParentDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [ParentDashboardController::class, 'updateProfile'])->name('profile.update');

    // Password
    Route::get('/change-password', [ParentDashboardController::class, 'showChangePassword'])->name('change-password');
    Route::put('/change-password', [ParentDashboardController::class, 'updatePassword'])->name('change-password.update');
});

/*
 | Temporary preview route for visual QA of teacher grades page.
 | Visible only in local development. Remove before production.
 */
if (app()->environment('local')) {
    Route::get('/dev/preview-grades', function () {
        // Attempt to login as the first teacher user so layout can access auth()->user()
        $firstTeacherUser = \App\Models\User::where('role', 'guru')->first();
        if ($firstTeacherUser) {
            try {
                \Illuminate\Support\Facades\Auth::loginUsingId($firstTeacherUser->id);
            } catch (\Throwable $e) {
                // Fallback to setUser if loginUsingId fails in this environment
                \Illuminate\Support\Facades\Auth::setUser($firstTeacherUser);
            }
            // Also ensure the auth user is set on the container for rendering
            \Illuminate\Support\Facades\Auth::setUser($firstTeacherUser);
        }

        $students = \App\Models\Student::with('user')->get();
        $selectedClass = '1A';
        $selectedStudentObj = $students->where('class', $selectedClass)->first();
        $selectedStudent = $selectedStudentObj ? $selectedStudentObj->id : null;
        $grades = $selectedStudent ? \App\Models\Grade::where('student_id', $selectedStudent)->get() : collect();
        $classes = ['1A','2A','3A','4A','5A','6A'];

        return view('teacher.grades-simple', [
            'students' => $students,
            'grades' => $grades,
            'classes' => $classes,
            'selectedClass' => $selectedClass,
            'selectedStudent' => $selectedStudent,
            'selectedStudentInfo' => $selectedStudentObj,
        ]);
    });
}
