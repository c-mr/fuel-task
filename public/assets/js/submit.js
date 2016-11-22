$(function() {

    // フォームのSUBMIT
    $('#check_button').click(function(ev) {
        $('#form').submit();
    });

    // 確認画面のSUBMIT
    $('#save_button').click(function(ev) {
        $('#form').submit();
    });

    // 確認画面から戻る
    $('#back_button').click(function(ev) {
        // fromタグを書き換えて遷移先を変える
        var url = location.protocol + '//' + location.host;
        $('#form').attr('action', url+'/staff/back');
        $('#form').submit();
    });

    // 削除確認アラート
    $('#delete_button').click(function(ev) {
        if (window.confirm('Delete it?')) {
            $('#form').submit();
        }
    });
});