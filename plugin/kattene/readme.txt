1．ソフト概要
たい氏が作成・配布している『カッテネ』を改変したソフトウェアになります。

【カッテネの参考URL】
https://webfood.info/make-kattene/

2．【改変内容】
『カッテネ』でアフィリエイトリンクを設定する "url" の部分を、"afi_url" と "url" に分割しました。
改変した理由は、検索した商品のURLを貼るだけにしたかったからです。

たとえば、「もしもアフィリエイト」を使っていると、アフィリエイトリンクは以下のようになります。
//af.moshimo.com/af/c/click?a_id=2040186&amp;p_id=170&amp;pc_id=185&amp;pl_id=4062&amp;url=https%3A%2F%2Fwww.amazon.co.jp%2Fdp%2FB07Q7S7247

これは以下のように2つに分割できます。
アフィリエイトIDのURL：//af.moshimo.com/af/c/click?a_id=2040186&amp;p_id=170&amp;pc_id=185&amp;pl_id=4062&amp;url=
商品のURL　　　　　　：https%3A%2F%2Fwww.amazon.co.jp%2Fdp%2FB07Q7S7247

アフィリエイトIDのURLは基本的に不変なので、この部分はテンプレートとして登録しておけば入力を省けます。
商品のURLはURLエンコードされたURLなので、普通にURLを貼り付けるとよろしくないです。（基本的に大丈夫らしいけど…不安）

というわけで、設定項目を "afi_url" と "url" に分離して、"url" に設定したURLは自動的にURLエンコードした後に結合するようにしました。

3．【インストール方法】
    ⅰ．たい氏のHPを参考に『カッテネ』をインストールしてください。（インストール済みであれば、この手順は不要です）
            https://webfood.info/make-kattene/

    ⅱ．この "readme.txt" と同階層にある "plugin.php" を『カッテネ』でインストールされた "plugin.php" に上書きしてください。
            『カッテネ』のインストールパスは以下にあると思うので、ファイルマネージャなどで上書きして頂ければ良いです。
            [カッテネのパス]
            wp-content/plugins/kattene/plugin.php

    ⅲ．WordPressの「インストール済みプラグイン」を参照して、「Kattene」から「Kattene_Custom」になっていれば、インストール完了です。

4．使用例
基本的な使い方は『カッテネ』と変わりありません。ただ、JSONの設定値に "afi_url" を追加します。

【JSONの記述例】
[kattene]
{
"image": "https://m.media-amazon.com/images/I/61Vd7Tx9rHL._AC_UY436_QL65_.jpg",
"title": "MX Master 3",
"description": "Logicool(ロジクール)",
"sites": [
{
"color": "orange",
"afi_url":"//af.moshimo.com/af/c/click?a_id=2040186&amp;p_id=170&amp;pc_id=185&amp;pl_id=4062&amp;url=",
"url": "https://www.amazon.co.jp/dp/B07XQ6XD8G",
"label": "Amazon",
"main": "true"
},
{
"color": "red",
"afi_url":"//af.moshimo.com/af/c/click?a_id=2017856&amp;p_id=54&amp;pc_id=54&amp;pl_id=616&amp;url=",
"url": "https://search.rakuten.co.jp/search/mall/MX+Master+3/",
"label": "楽天"
},
{
"color": "green",
"afi_url":"//af.moshimo.com/af/c/click?a_id=2042548&amp;p_id=1225&amp;pc_id=1925&amp;pl_id=18502&amp;url=",
"url": "https://shopping.yahoo.co.jp/search?first=1&amp;tab_ex=commerce&amp;fr=shp-prop&amp;oq=&amp;aq=&amp;mcr=a52d8e4cd0348762ddd2666aad9a29e7&amp;ts=1639550431&amp;p=MX+Master+3&amp;cid=&amp;pf=&amp;pt=&amp;area=13&amp;astk=&amp;sc_i=shp_pc_top_searchBox_2&amp;sretry=1",
"label": "Yahoo"
}
]
}
[/kattene]

たとえば、以下のようなテンプレートを作っておけば、商品検索したURLを貼り付けるだけでOKになります。
【テンプレートの例】
[kattene]
{
"image": "",
"title": "",
"description": "",
"sites": [
{
"color": "orange",
"afi_url":"//af.moshimo.com/af/c/click?a_id=2040186&amp;p_id=170&amp;pc_id=185&amp;pl_id=4062&amp;url=",
"url": "",
"label": "Amazon",
"main": "true"
},
{
"color": "red",
"afi_url":"//af.moshimo.com/af/c/click?a_id=2017856&amp;p_id=54&amp;pc_id=54&amp;pl_id=616&amp;url=",
"url": "",
"label": "楽天"
},
{
"color": "green",
"afi_url":"//af.moshimo.com/af/c/click?a_id=2042548&amp;p_id=1225&amp;pc_id=1925&amp;pl_id=18502&amp;url=",
"url": "",
"label": "Yahoo"
}
]
}
[/kattene]

なお、"afi_url" を追加しなくても動作します。その場合は従来通りの『カッテネ』の動作をします。
そうしないと、これまでの記事に入れた『カッテネ』のJSONをすべて書き換える必要が出てしまい、面倒だと思ったので。
