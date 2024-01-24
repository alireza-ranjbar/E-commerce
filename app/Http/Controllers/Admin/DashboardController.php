<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function chartValues()
    {
        $months = 12;
        $startDate = verta()->startMonth()->subMonth($months - 1);
        $successfulTransactions = Transaction::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', now())
            ->where('status', 1)->get();

        $unsuccessfulTransactions = Transaction::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', now())
            ->where('status', 0)->get();

        $successfulTransactionsArray = $this->calculateMonthsValues($months, $successfulTransactions);
        $unsuccessfulTransactionsArray = $this->calculateMonthsValues($months, $unsuccessfulTransactions);

        return view('admin.dashboard', [
            'labels' => array_keys($successfulTransactionsArray),
            'successfulValues' => array_values($successfulTransactionsArray),
            'unsuccessfulValues' => array_values($unsuccessfulTransactionsArray),
            'transactions' => [$successfulTransactions->count(),$unsuccessfulTransactions->count()],
        ]);
    }

    public function calculateMonthsValues($months, $transactions)
    {
        $result = [];

        //adds 0 to all 12 months
        $i = 0;
        for ($i; $i < $months; $i++) {
            $startDate = verta()->startMonth()->subMonth($months - $i - 1);
            $key = verta($startDate)->format('%B %y');
            if (!array_key_exists($key, $result)) {
                $result[$key] = 0;
            }
        }

        //adds value to some months
        foreach ($transactions as $transaction) {
            $key = verta($transaction->created_at)->format('%B %y');
            $amount = $transaction->amount;
            if (array_key_exists($key, $result)) {
                $result[$key] += $amount;
            } else {
                $result[$key] = $amount;
            }
        }

        return $result;
    }
}
