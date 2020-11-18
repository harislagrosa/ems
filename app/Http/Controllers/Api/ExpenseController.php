<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Expense;
use App\Models\User;

class ExpenseController extends Controller
{
    public function index()
    {
        return ExpenseResource::collection(Expense::get());
    }

    public function show($userId)
    {
        $user = User::where('id', $userId)->first();

        if ($user->role_id != 1) {
            $expense = Expense::where('user_id', $user->id)->get();
        }
        else {
            $expense = Expense::get();
        }

        return ExpenseResource::collection($expense);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|not_in:1',
            'entry_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        $expense = new Expense;
        $expense->user_id = $request->id;
        $expense->category_id = $request->category;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->entry_date;
        $expense->save();
        return response()->json(['success' => 'New Expense has been added!']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|not_in:1',
            'entry_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        $expense = Expense::findOrFail($id);
        $expense->category_id = $request->category;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->entry_date;
        $expense->save();
        return response()->json(['success' => 'Expense successfully Updated!']);
    }

    public function destroy(Request $request, Expense $expense)
    {
        $expense->delete();
        return response()->json(['success' => 'Expense successfully deleted!']);
    }
}
