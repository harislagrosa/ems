<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $page = [
            'title' => 'Dashboard | ' . env('APP_NAME')
        ];

        return view('user.index', compact('page'));
    }

    public function show(Request $request, $userId)
    {
        // if ($request->ajax()) {
            $user = User::findOrFail($userId);

            if ($user->role_id != 1) {
            $expenses = Expense::select(DB::raw('category_id'), DB::raw('sum(amount) as amount'))
                            ->groupBy(DB::raw('category_id'))
                            ->where('user_id', $user->id)
                            ->get();
            } else {
            $expenses = Expense::select(DB::raw('category_id'), DB::raw('sum(amount) as amount'))
                            ->groupBy(DB::raw('category_id'))
                            ->get();
            }

            $array = array();
            foreach ($expenses as $key => $expense) {
                $new = array(
                    'category' => $expense->category->category,
                    'amount' => $expense->amount
                );
                array_push($array, $new);
            }

            return $array;
        // }
        // else {
        //     abort(404);
        // }
    }
}
