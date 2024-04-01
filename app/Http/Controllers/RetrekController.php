<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use App\Models\FavoriteRoute;
use App\Models\DislikedRoute;

class RetrekController extends Controller
{
    public function user()
    {
        // 認証されたユーザーIDを取得する
        $userId = auth()->id();

        // そのユーザーのお気に入りの経路を取得
        $favoriteRoutes = FavoriteRoute::where('user_id', $userId)->get();

        // ビューにデータを渡して表示
        return view('user', ['favoriteRoutes' => $favoriteRoutes]);
    }

    public function results()
    {
        // // 認証されたユーザーIDを取得する
        // $userId = auth()->id();

        // // そのユーザーのお気に入りの経路を取得
        // $favoriteRoutes = FavoriteRoute::where('user_id', $userId)->get();



        
        //外部スクリプトの実行
        $process = new Process(["docker", "exec", "retrek-ui-python-1", "python3", "/app/exe.py", "CCO", "3", "1.0, 1.0, 1.0, 1.0, 1.0, 1.0", "False", "50", "False", "False", "10", "0"]);
        $process->run();
        //docker exec retrek-ui-python-1 python3 /app/exe.py "CCO" "3" "1.0, 1.0, 1.0, 1.0, 1.0, 1.0" "False" "50" "False" "False" "10" "0"
        // 実行に失敗した場合(失敗の原因の場所の究明)
        if(!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }
        //外部スクリプトの実行結果（出力）の取得
        $output = $process->getOutput();
        // ビューにデータを渡して表示
        return view('results', ['output' => $output]);
    }

    public function exepy(Request $request)
    {
        #化学式
        $smiles = $request->input('smiles');


        $routes = $request->input('routes');


        $weights = $request->input('weights');
        // 配列をカンマ区切りの文字列に変換
        $weightsString = implode(', ', $weights);

        
        $save_tree = $request->input('save_tree');
        $expansion_num = $request->input('expansion_num');
        $cum_prob_mod = $request->input('cum_prob_mod');
        $chem_axon = $request->input('chem_axon');
        $selection_constant = $request->input('selection_constant');
        $time_limit = $request->input('time_limit');


        //外部スクリプトの実行
        $process = new Process(["docker", "exec", "retrek-ui-python-1", "python3", "/app/exe.py", $smiles, $routes, $weightsString, $save_tree, $expansion_num, $cum_prob_mod, $chem_axon, $selection_constant, $time_limit]);
        $process->run();
        //docker exec retrek-ui-python-1 python3 /app/exe.py "CCO" "3" "1.0, 1.0, 1.0, 1.0, 1.0, 1.0" "False" "50" "False" "False" "10" "0"

        // 実行に失敗した場合(失敗の原因の場所の究明)
        if(!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }

        //外部スクリプトの実行結果（出力）の取得
        $output = $process->getOutput();

        return view('results', ['output' => $output]);
    }


    public function saveFavoriteRoute(Request $request, $userId)
    {
        // お気に入りの経路を保存
        $favoriteRoute = new FavoriteRoute();
        $favoriteRoute->user_id = $userId;
        $favoriteRoute->description = $request->favorite_route; // 仮のパラメータ名
        $favoriteRoute->save();

        // 苦手な経路を保存
        $dislikedRoutesDescriptions = $request->disliked_routes; // 仮のパラメータ名、配列を想定
        foreach ($dislikedRoutesDescriptions as $description) {
            $dislikedRoute = new DislikedRoute();
            $dislikedRoute->user_id = $userId;
            $dislikedRoute->description = $description;
            $dislikedRoute->save();
        }

        // レスポンスなど後続の処理
        //　TODO　選択された経路のお気に入り登録ボタンが押せなくなるようにする

        // そのユーザーの全てのお気に入りの経路を取得
        $favoriteRoutes = FavoriteRoute::where('user_id', $userId)->get();
        // ビューにデータを渡して表示
        return view('user', ['favoriteRoutes' => $favoriteRoutes]);
        
    }
}
