<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Province;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $month = 14;

        $successTransactions = Order::getData($month, 1);
        $successTransactionsChart = $this->chart($successTransactions, $month);

        $failTransactions = Order::getData($month, 0);
        $failTransactionsChart = $this->chart($failTransactions, $month);

        $zarinpal = Order::getGatewayData($month, 1 , 'online');
        $snapp = Order::getGatewayData($month, 1 , 'snapppay');
        $card = Order::getGatewayData($month, 1 , 'card');

        $registeredUser  = User::getRegisterData($month);
        $registeredUserChart  = $this->userChart($registeredUser, $month);

        $productCategories = Category::where('id' ,'!=' , 1)->orderBy('viewed' , "desc")->take(7)->get();
        $productTags = Tag::orderBy('viewed' , "desc")->take(4)->get();
        $products = Product::orderBy('viewed' , "desc")->take(7)->get();
        $articleCategories = Blog::orderBy('viewed' , "desc")->take(7)->get();
        $articles = Article::orderBy('viewed' , "desc")->take(7)->get();

        $provinces=Province::query()->withCount('user_address')->orderBy('user_address_count', 'DESC')->take(5)->get();
        $orders=Product::query()->withCount('orders')->orderBy('orders_count', 'DESC')->where('status' , 1)->take(5)->get();




        return view('master.report.index', [
            'successTransactions' => array_values($successTransactionsChart),
            'failTransactions' => array_values($failTransactionsChart),
            'registeredUser' => array_values($registeredUserChart),
            'transactionsCount' => [$zarinpal->count() , $snapp->count(), $card->count()],
            'statusTransactionsCount' => [$successTransactions->count() , $failTransactions->count()],
            'registeredUserCount' => [$registeredUser->count()],
            'labels' => array_keys($successTransactionsChart),
            'userLabels' => array_keys($registeredUserChart),
        ] , compact(['productCategories'  , 'productTags'  , 'products' ,  'articleCategories' , 'articles' , 'provinces'  ,  'orders']));
    }

    public function chart($transactions, $month)
    {
        $monthName = $transactions->map(function ($item) {
            return verta($item->created_at)->format('%B %y');
        });

        $amount = $transactions->map(function ($item) {
            return $item->amount;
        });

        foreach ($monthName as $i => $v) {
            if (!isset($result[$v])) {
                $result[$v] = 0;
            }
            $result[$v] += $amount[$i];
        }

        if (count($result) != $month) {
            for ($i = 0; $i < $month; $i++) {
                $monthName = verta()->subMonth($i)->format('%B %y');
                $shamsiMonths[$monthName] = 0;
            }
            return array_reverse(array_merge($shamsiMonths, $result));
        }
        return $result;
    }

    public function userChart($users, $month)
    {

        $monthName = $users->map(function ($item) {
            return verta($item->created_at)->format('%B %y');
        });
        $amount = $users->map(function ($item) {
            for ($i = 1; $i < 100000000000; $i++) {
                return $i;
            }
        });
        foreach ($monthName as $i => $v) {
            if (!isset($result[$v])) {
                $result[$v] = 0;
            }
            $result[$v] += $amount[$i];
        }

        if (count($result) != $month) {
            for ($i = 0; $i < $month; $i++) {
                $monthName = verta()->subMonth($i)->format('%B %y');
                $shamsiMonths[$monthName] = 0;
            }
            return array_reverse(array_merge($shamsiMonths, $result));
        }
        return $result;
    }

}
