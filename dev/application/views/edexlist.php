<div class="container">
    <div class="row">
        <h1>EDEXReader</h1>
        <div class="col-sm-12" style="padding-top:25px;">
            <div class="panel-group">
                <div style="height:520px; overflow: hidden; overflow-y: auto; background: #444; color:#fff;">
                    <?php echo '<pre><code>' . print_r($xmlTree) . '</code></pre>';
                    function search($array, $key, $value = '')
                    {
                        $results = array();
                        if (is_array($array)) {
                            if (isset($array[$key]) && $array[$key] == $value) {
                                $results[] = $array;
                            }
                            foreach ($array as $subarray) {
                                $results = array_merge($results, search($subarray, $key, $value));
                            }
                        }
                        return $results;
                    }

                    $key = search($xmlTree, 'AUTEUR');
                    echo $key;
                    ?>
                    <ul class="list-group" id="datalist"></ul>
                </div>
            </div>
        </div>
    </div>
</div>