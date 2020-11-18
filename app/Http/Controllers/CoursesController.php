<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class CoursesController
 * @package App\Http\Controllers
 */
class CoursesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(auth()->user()->role==='teacher'){
            $user_id =auth()->user()->id;
        
            // $courses = Course::where('user_id','=',$user_id)->paginate();
            
            $courses = User::find($user_id)->courses()->paginate();

        }
        else{
            $courses = Course::paginate();
        }
        
        
        return view('course.index', compact('courses'))
            ->with('i', (request()->input('page', 1) - 1) * $courses->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = new Course();
        return view('course.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Course::$rules);
        $data = $request->all();
        //return $data;
        $data['user_id'] = auth()->user()->id;
        
        Course::create($data);
 
        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);

        return view('course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);

        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        request()->validate(Course::$rules);

        $course->update($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();
        
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }

     /**
     * student enrolls in a course
     */
    public function enroll($course_id)
    {   

        $student= auth()->user();

        $student->courses_st()->attach([$course_id]);

        return redirect()->route('courses.index')
            ->with('success', 'Course Enrolled successfully.');
    }
   
    public function storeFeedback(Request $request){
        
        $request->validate([
            'feedback'=>'required',
        ]);
   
        $feedback = $request->input('feedback');
        $user_id = $request->input('user_id');
        $course_id = $request->input('course_id');
        
        $user = User::find($user_id);
        $course = Course::find($course_id);

        // here is two mehtods to update feedback column in course_user table
        // 1
        // $user->courses_st()->updateExistingPivot($course, array('feedback' => $feedback));
        // 2
        $course->students()->updateExistingPivot($user, array('feedback' => $feedback));
        
        return redirect()->route('courses.show',$course_id)
            ->with('success', 'Your Feedback is stored successfully.');

    }

    public function deleteFeedback(Request $request){
        $user_id = $request->input('user_id');
        $course_id = $request->input('course_id');
        
        $user = User::find($user_id);
        $course = Course::find($course_id);
        
        $course->students()->updateExistingPivot($user, array('feedback' => null));
        
        return redirect()->route('courses.show',$course_id)
            ->with('success', 'Your Feedback is deleted.');
    }
}
