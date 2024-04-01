<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReTReK - ユーザー検索画面</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4" style="color: #17a2b8;">ユーザー検索画面</h2>
        <form action="{{ route('exepy') }}" method="POST" class="mb-3">
            @csrf
            <div class="form-group">
                <label for="smiles">SMILES化学式:</label>
                <input type="text" name="smiles" class="form-control" required>
            </div>
                <!-- ここから設定UI -->
            <fieldset>
                <legend class="mb-3">詳細設定</legend>

                <div class="form-group row mb-2">
                    <label for="routes" class="col-sm-4 col-form-label">ルート数:</label>
                    <div class="col-sm-8">
                        <input type="number" name="routes" class="form-control" required value="3" min="1">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label">knowledgeWeights:</label>
                    <div class="col-sm-8">
                        <div class="row">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="col">
                                    <input type="number" class="form-control mb-2" name="weights[]" id="weights[{{ $i }}]" step="0.1" value="1.0" placeholder="{{ $i + 1 }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="expansion_num" class="col-sm-4 col-form-label">expansion_num:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="expansion_num" value="50">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="selection_constant" class="col-sm-4 col-form-label">selection_constant:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="selection_constant" id="selection_constant" value="10">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="time_limit" class="col-sm-4 col-form-label">time_limit:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="time_limit" id="time_limit" value="0">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label" for="save_tree">save_tree:</label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input type="checkbox" name="save_tree" class="form-check-input" id="save_tree" value="True">
                            <label class="form-check-label" for="save_tree"></label>
                        </div>
                    </div>
                </div>                

                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label" for="cum_prob_mod">cum_prob_mod:</label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input type="checkbox" name="cum_prob_mod" class="form-check-input" id="cum_prob_mod" value="True">
                            <label class="form-check-label" for="cum_prob_mod"></label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label" for="chem_axon">chem_axon:</label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input type="checkbox" name="chem_axon" class="form-check-input" id="chem_axon" value="True">
                            <label class="form-check-label" for="chem_axon"></label>
                        </div>
                    </div>
                </div>


            </fieldset>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>

        <!-- お気に入りの合成経路リストの欄 -->
        <section>
            <h3>お気に入りの合成経路</h3>  
            <ul class="list-group">
                <!-- Todo 各お気に入りの経路に検索のルートのパスをaタグとして渡す -->
                @forelse($favoriteRoutes as $route)
                    <li class="list-group-item">{{ $route->description }}</li> <!-- ここで$favoriteRoutesはユーザーのお気に入りの合成経路リストを表す -->
                @empty
                    <li class="list-group-item">お気に入りの合成経路はありません。</li>
                @endforelse
            </ul>
        </section>
    </div>
    
</body>
</html>