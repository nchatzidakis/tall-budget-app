<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\ExpenseIndexRequest;
use App\Http\Requests\Tenant\ExpenseStoreRequest;
use App\Http\Requests\Tenant\ExpenseUpdateRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Repositories\AccountRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(ExpenseIndexRequest $request): View
    {
        // TODO Datatable with livewire or other async
        $expenses = Expense::orderByDesc('paid_at')
            ->limit(100)
            ->when(request()->has('account_id'), fn ($query) => $query->where('account_id', request('account_id')))
            ->get();

        return view('tenant.expense.index', [
            'expenses' => $expenses,
        ]);
    }

    public function create(): View
    {
        return view('tenant.expense.create', [
            'accounts' => AccountRepository::allByRecent(),
            'categories' => Category::orderBy('position')->whereNull('parent_id')->get(),
        ]);
    }

    public function store(ExpenseStoreRequest $request): RedirectResponse
    {
        $input = request()->all();
        $input['transactionAmount'] = request('transactionAmount') / 100;
        //TODO iphone is not working with decimal in form correctly
        $expense = Expense::create($input);

        // TBD transfer it to Service
        $expense->account->currentBalance = $expense->account->currentBalance - $input['transactionAmount'];
        $expense->account->save();

        return redirect()->route('expense.index', tenant());
    }

    public function edit(int $id): View
    {
        return view('tenant.expense.edit', [
            'expense' => Expense::find($id),
            'accounts' => AccountRepository::allByRecent(),
            'categories' => Category::orderBy('position')->whereNull('parent_id')->get(),
        ]);
    }

    public function update(ExpenseUpdateRequest $request, int $id): RedirectResponse
    {
        $input = request()->all();
        $input['transactionAmount'] = request('transactionAmount') / 100;

        $expense = Expense::find($id);

        // TODO: BUG when changing account!!!!
        $expense->account->currentBalance = $expense->account->currentBalance + $expense->transactionAmount - $input['transactionAmount'];
        $expense->account->save();

        $expense->update($input);

        return redirect()->route('expense.index', tenant());
    }

    public function destroy(int $id): RedirectResponse
    {
        $expense = Expense::find($id);

        $expense->account->currentBalance = $expense->account->currentBalance + $expense->transactionAmount;
        $expense->account->save();

        $expense->delete();

        return redirect()->route('expense.index', tenant());
    }
}
