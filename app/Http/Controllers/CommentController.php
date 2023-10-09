<?php

namespace App\Http\Controllers;

use App\Mail\sendmail;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Review;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'comment'=>'required|min:5|max:500'
        ]);
        $comment=new Comment();
        $comment->user_id=Auth::user()->id;
        $comment->question_id=$request->question_id;
        $comment->comment=$request->comment;
        $comment->save();
        $question = Question::find($request->question_id);
        $commentAuthorName = Auth::user()->name;
        $commentLink = url('question/'.$request->question_id.'/details');

        // Send the HTML email
        Mail::to($question->user->email)->send(new sendmail($question->title, $commentAuthorName, $commentLink));
        return redirect()->back()->with(['success' => 'Comment has been added']);
    }
    public function add_rating(Request $request)
    {
        $commentId = $request->input('commentId');
        $rating = $request->input('rating');
        $user = Auth::user();

        // Check if the user has already rated this comment
        $existingRating = Review::where('user_id', $user->id)
            ->where('comment_id', $commentId)
            ->first();

        if ($existingRating) {
            $existingRating->reviews = $rating;
            $existingRating->save();
        } else {
            $newRating = new Review();
            $newRating->user_id = $user->id;
            $newRating->comment_id = $commentId;
            $newRating->reviews = $rating;
            $newRating->save();
        }

        $comment = Comment::find($commentId);
        $totalReviews = $comment->reviews()->count();
        $excellentCount = $comment->reviews()->where('reviews', 'excelent')->count();
        $goodCount = $comment->reviews()->where('reviews', 'good')->count();
        $badCount = $comment->reviews()->where('reviews', 'bad')->count();

        $excellentPercent = ($excellentCount / $totalReviews) * 100;
        $goodPercent = ($goodCount / $totalReviews) * 100;
        $badPercent = ($badCount / $totalReviews) * 100;

        return response()->json([
            'message' => 'Rating added successfully',
            'excellent_percent' => $excellentPercent,
            'good_percent' => $goodPercent,
            'bad_percent' => $badPercent,
        ]);
    }


    public function add_vote(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        $user = Auth::user();
        $comment = Comment::findOrFail($request->input('comment_id'));

        // Check if the user has already voted on this comment
        $existingVote = Vote::where('user_id', $user->id)
            ->where('comment_id', $comment->id)
            ->first();

        if ($existingVote) {
            if ($existingVote->vote_type !== $request->input('vote_type')) {
                $existingVote->vote_type = $request->input('vote_type');
                $existingVote->save();
            } else {
                return response()->json(['message' => 'Already have voted']);
            }
        } else {
            // User hasn't voted yet, create a new vote record
            $vote = new Vote();
            $vote->user_id = $user->id;
            $vote->comment_id = $comment->id;
            $vote->vote_type = $request->input('vote_type');
            $vote->save();
        }

        // Calculate the updated upvote count for the comment
        $upvoteCount = Vote::where('vote_type', 'upvote')
            ->where('comment_id', $comment->id)
            ->count();

        return response()->json([
            'message' => 'Voting added successfully',
            'upvote_count' => $upvoteCount,
        ]);
    }

}
