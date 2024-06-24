<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AllotSubject;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\ImageViewController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\ZoomController;

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




// User Login
Route::get('/staffLogin',[AuthController::class,'staffLogin'])->name('staffLogin');
Route::post('/staffLogin',[AuthController::class,'staffLoginCheck'])->name('staffLoginCheck');
Route::get('/terms-and-condtions',[AuthController::class,'termAndcondition'])->name('termAndcondition');

Route::group(['middleware'=>'checkStaff'],function(){

Route::post('/fetch-city',[StudentController::class,'fetchCity'])->name('fetchCity');
Route::get('/add-subject/{id}',[CategoryController::class,'modelPreview']);
Route::post('/view-active-category',[CategoryController::class,'fetchActiveRecord']);
Route::post('/view-deactive-category',[CategoryController::class,'fetchDeactiveRecord']);
Route::get('/course/batch/{id}',[BatchController::class,'showCourseBatches']);
Route::post('/update-batch-status',[BatchController::class,'updateStatus']);
Route::post('/search-batch',[BatchController::class,'searchBatch']);
Route::post('/delete-batch',[BatchController::class,'deleteBatch'])->name('delete.batch');
Route::post('/view-active-batch',[BatchController::class,'fetchActiveRecord']);
Route::post('/view-deactive-batch',[BatchController::class,'fetchDeactiveRecord']);
Route::post('/view-ended-batch',[BatchController::class,'fetchEndedRecord']);
Route::post('/create-new-batch',[BatchController::class,'createBatch']);
Route::get('/batch/allot/{id}',[AllotSubject::class,'allotSubject']);
Route::post('/update-course-batch',[BatchController::class,'updateCourseBatch']);
Route::post('/update-batch-Data',[BatchController::class,'batchUpdate']);
Route::post('/allot-subject-student',[AllotSubject::class,'allotBatchSubject']);
Route::post('/fetch-student-details',[AllotSubject::class,'fetchStudentDetails']);
Route::get('/course-subject/{id}',[CategoryController::class,'showSubject']);
Route::post('/filter-course-subject',[CategoryController::class,'fetchSubjectByStatus']);
Route::post('/search-course-subject',[CategoryController::class,'searchSubject']);
Route::post('/update-subject-status',[CategoryController::class,'updateCourseSubjectStatus']);
Route::post('/delete-course-subject',[CategoryController::class,'deleteCourseSubject']);
Route::post('/add-new-subject',[CategoryController::class,'addNewSubject']);
Route::post('/fetch-subject-record',[CategoryController::class,'fetchSubjectRecord']);
Route::post('/update-course-subject',[CategoryController::class,'updateCourseSubject']);
Route::post('/fetch-batch-course',[AllotSubject::class,'fecthCourseBatch']);
Route::post('/fetch-batch-subject',[AllotSubject::class,'fetchbatchSubject']);
Route::post('/alloted-batch-student',[AllotSubject::class,'singlestudentBatch']);
Route::get('/batch/unallot/{id}',[AllotSubject::class,'unallotSubject']);
Route::post('/fetch-student-data/{id}',[studentController::class,'fetchStudent']);
Route::post('/update-student-pass',[studentController::class,'updatePass']);
Route::post('/unallot-subject-student',[AllotSubject::class,'unallotBatchSubject']);
Route::post('/fetch-alloted-subject-details',[AllotSubject::class,'fetchAllotedStudentDetails']);

Route::get('/dashboard',[TeacherController::class,'dashboard']);
Route::get('/staffLogout',[AuthController::class,'stafflogout'])->name('logout');
Route::get('/teacher-profile/{id}',[TeacherController::class,'teacherProfile']);
Route::post('/update-teacher-profile',[TeacherController::class,'UpdateTeacherProfile']);
Route::get('/profile/{id}',[AuthController::class,'adminProfile']);
Route::post('/profile',[AuthController::class,'updateAdminProfile']);
Route::post('/updateStaffPass',[AuthController::class,'updatePass']);


// Allot Batch
Route::get('/allot-batch/{id}',[AllotSubject::class,'index']);
Route::post('/allot-batch',[AllotSubject::class,'allotBatch']);
Route::post('/active-Student-batch',[AllotSubject::class,'activeStudentbatch']);
Route::post('/unalloted-student',[AllotSubject::class,'unallotBatch']);
Route::get('/alloted-batch-student/{id}',[AllotSubject::class,'studentAllotBatch']);
// For Batch
Route::get('/create-batch',[BatchController::class,'index']);
Route::post('/create-batch',[BatchController::class,'insert']);
Route::get('/all-batch',[BatchController::class,'records']);
Route::get('/batch-edit/{id}',[BatchController::class,'singleRecord']);
Route::post('/update-batch',[BatchController::class,'update']);
Route::post('/search-deactive-batch',[BatchController::class,'searchDeactive']);
Route::post('/search-ended-batch',[BatchController::class,'searchEnded']);
Route::get('/view/subject/{id}',[BatchController::class,'showSubject']);
Route::get('/add/subject/{id}',[BatchController::class,'addSubject']);

// For Category
Route::get('/category',[CategoryController::class,'index']);
Route::post('/category',[CategoryController::class,'insert']);
Route::get('/view-category',[CategoryController::class,'view']);
Route::post('/category/delete',[CategoryController::class,'destroy'])->name('delete.category');
Route::post('/update-course-status',[CategoryController::class,'updateStatus']);
Route::get('/category/edit/{id}',[CategoryController::class,'singleRecord'])->name('edit.category');
Route::post('/update-Category',[CategoryController::class,'update']);
Route::post('/search-category',[CategoryController::class,'search']);

// For Sub-Category
Route::get('/subcategory',[SubCategoryController::class,'index']);
Route::post('/subcategory',[SubCategoryController::class,'store']);
Route::get('/view-subcategory',[SubCategoryController::class,'view']);
Route::get('/subcategory/delete/{id}',[SubCategoryController::class,'destroy'])->name('delete.subcategory');
Route::get('/subcategory/edit/{id}',[SubCategoryController::class,'singleRecord'])->name('edit.subcategory');
Route::post('/update-category',[SubCategoryController::class,'update']);
Route::post('/search-subcategory',[SubCategoryController::class,'search']);

// For Subjects
// Route::get('/create-subject',[SubjectController::class,'index']);
Route::post('/fetch-subcategory/{id}',[SubjectController::class,'fetchSubcategory']);
Route::post('/create-subject',[SubjectController::class,'insert']);
Route::get('/subject',[SubjectController::class,'view']);
Route::get('/subject/edit/{id}',[SubjectController::class,'singleRecord'])->name('edit.subject');
// Route::get('/subject/delete/{id}',[SubjectController::class,'destroy'])->name('delete.subject');
Route::post('/update-subject',[SubjectController::class,'update']);
Route::post('/search-subject',[SubjectController::class,'search']);
Route::post('/filter-subject',[SubjectController::class,'filter']);

// For Teacher
Route::get('/add-teacher',[TeacherController::class,'index']);
Route::post('/add-teacher',[TeacherController::class,'insert']);
Route::get('/teachers',[TeacherController::class,'view']);
Route::get('/teacher/delete/{id}',[TeacherController::class,'destroy'])->name('delete.teacher');
Route::get('/teacher/edit/{id}',[TeacherController::class,'singleRecord'])->name('edit.teacher');
Route::post('/update-teacher',[TeacherController::class,'update']);
Route::post('/fetch-teacher/{id}',[TeacherController::class,'fetchTeacher']);
Route::post('/teacher/passUpdate',[TeacherController::class,'updatepass']);
Route::post('/search-teacher',[TeacherController::class,'search']);

// For Students
Route::get('/add-student',[StudentController::class,'index']);
Route::post('/add-student',[StudentController::class,'insert']);
Route::get('/students',[StudentController::class,'view']);

// Route::get('/student/delete/{id}',[StudentController::class,'destroy'])->name('delete.student');
Route::get('/student/edit/{id}',[StudentController::class,'singleRecord'])->name('edit.student');
Route::post('/update-student',[StudentController::class,'update']);
Route::post('/search-student',[StudentController::class,'search']);
Route::post('/filter-student',[StudentController::class,'filter']);
Route::post('/update-student-status',[StudentController::class,'updateStatus']);


Route::get('/sub-admins',[SubAdminController::class,'index']);
Route::post('/create-subAdmin',[SubAdminController::class,'createSubAdmin']);
Route::post('/delete-subadmin',[SubAdminController::class,'deleteSubAdmin']);
Route::post('/update-subadmin-details',[SubAdminController::class,'editSubAdmin']);
Route::post('/update-subadmin',[SubAdminController::class,'updateSubadmin']);
Route::post('/fetch-subadmin',[SubAdminController::class,'fetchSubAdminByStatus']);
Route::post('/update-subadmin-status',[SubAdminController::class,'updateStatus']);
Route::post('/search-subadmin',[SubAdminController::class,'search']);
Route::get('/all-online-classes/{subjectId}',[CategoryController::class,'allOnlineClasses']);
Route::post('/store-online-class',[ZoomController::class,'storeOnlineClass']);
Route::get('/online-class-remove',[ZoomController::class,'onlineClassRemove']);
Route::get('/teachers-time-table',[TimetableController::class,'teachersTimeTable']);
Route::get('/get-batch-with-course',[TimetableController::class,'getBatchWithCourse']);
Route::post('/store-teacher-timetable',[TimetableController::class,'storeTeacherTimetable']);

Route::get('/learners-attendance',[TimetableController::class,'learnersAttendance']);
Route::get('/take-attendance/{timetableId}',[TimetableController::class,'takeAttendance']);
Route::post('/store-student-attendance',[TimetableController::class,'storeStudentAttendance']);


});

// Upload Folder
Route::get('/subject/upload/{id}',[FolderController::class,'index'])->name('upload.subject');
Route::post('/upload-data',[FolderController::class,'Upload']);
Route::post('/upload-subdata',[FolderController::class,'Uploadsub']);
Route::post('/child-folder',[FolderController::class,'showchild']);
Route::get('/delete-data/{id}',[FolderController::class,'deleteData']);

//FILE UPLOADS CONTROLER
Route::post('/medialibrary/upload', [FolderController::class, 'uploadListingGallery'])->name('file-upload');
Route::post('/medialibrary/delete', [FolderController::class, 'delete'])->name('file-delete');
Route::get('course-media/{subjectId}/{file}',[ImageViewController::class,'courseMedia']);
Route::get('access-course-media/{subjectId}/{fileId}',[ImageViewController::class,'accessCourseMedia']);
Route::get('course-media-file/{subjectId}/{file}',[ImageViewController::class,'courseMediaFile']);

// For Student Login
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'studentLogin'])->name('login');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'studentRegisteration'])->name('register');
Route::get('/verify-mobile-number',[AuthController::class,'verifyMobileNumber']);
Route::post('/register-process',[AuthController::class,'registerProcess']);
Route::post('/set-user-mob',[AuthController::class,'setUserMob']);
Route::get('/admin/login',[AuthController::class,'adminLogin'])->name('admin.login');
Route::post('/adminLogincheck',[AuthController::class,'adminLogincheck']);

Route::group(['middleware'=>'checkStudent'],function(){
    Route::get('/',[StudentController::class,'studentDashboard']);
    Route::get('/student-profile',[StudentController::class,'studentProfile']);
    Route::post('/student-profile',[StudentController::class,'updateStudentProfile']);
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    Route::post('/complete-regestration',[AuthController::class,'completeRegestration']);
    Route::get('/student-subjects',[StudentController::class,'allotedBatch']);
    Route::get('/student-online-classes',[StudentController::class,'studentOnlineClasses']);
    Route::get('/student/subject/{id}',[studentController::class,'showStudentSubject']);
    Route::get('/subject-details/{id}',[studentController::class,'subjectDetails']);
    Route::post('/updateStudentPass',[studentController::class,'updateStudentPass']);
    Route::post('/fetch-city-student',[StudentController::class,'fetchCityStudent']);
});

// Route::group(['middleware'=>['auth']],function(){
//     Route::get('online-classes',[ZoomController::class,'onlineClasses']);
//     Route::get('current-meeting',[ZoomController::class,'currentMeeting']);
// });

Route::get('online-classes',[ZoomController::class,'onlineClasses']);
Route::get('current-meeting',[ZoomController::class,'currentMeeting']);

Route::get('create-new-meeting',[ZoomController::class,'createNewMeeting']);


Route::post('get-stu-mobile',[AuthController::class,'getStuMobile']);
Route::post('set-user-mob-sess',[AuthController::class,'setUserMobSess']);

Route::get('logout-device/{id}',[AuthController::class,'logoutDevice']);





// Route::get('/logout', function () {
//     return view('user.dashboard');
// });

Route::get('/test', function (Request $request) {
    $data = \DB::table('sessions')
    ->where('user_id', \Auth::user()->id)
    ->get();
    echo'<table border="1">';
    foreach($data as $v){
        echo "<tr>";
            echo "<td>".$v->user_agent."</td>";
            echo "<td>".$v->ip_address."</td>";
        echo "</tr>";
    }
    echo'</table>';
});

