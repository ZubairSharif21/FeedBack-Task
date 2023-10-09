<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'title'=>'required|min:6|max:255',
            'description'=>'required|min:6|max:800',
            'image'=>'sometimes|mimes:png,jpg,webp,gif,jpeg',
        ]);
        $question=new Question();
        $question->user_id = auth()->user()->id;
        $question->title=$request->title;
        if($request->hasFile('image')){

            $file = $request->file('image');
          $filename =time(). '_' . $file->getClientOriginalName();
          $file->storeAs('public/',$filename);
          $question->image=$filename;

        }
        $question->description=$request->description;
        $question->save();
        return redirect()->back()->with(['success' => 'Question has been added']);
    }
    public function details($id){
        $question = Question::with('comments')->find($id);
        $comments = Comment::select('comments.*')
        ->leftJoin('votes', function ($join) {
            $join->on('comments.id', '=', 'votes.comment_id')
                ->where('votes.vote_type', '=', 'upvote');
        })
        ->where('comments.question_id', '=', $id)
        ->groupBy('comments.id')
        ->orderByRaw('COUNT(votes.id) DESC')
        ->paginate(10);
// dd($comments);
// if($question->comments->isNotEmpty()){
//     dd($question->comments);
// }
// else dd('asd');
return view('front.question-details', compact('question', 'comments'));

    }
    public function search(Request $request)
    {
        $query = $request->input('search');
        $questions = Question::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->paginate(8);
        return view('front.home', compact('questions'));
    }

}
