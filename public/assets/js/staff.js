$(function() {
    // 検索
    $('#serach_button').click(function(ev) {
        $('#form').submit();
    });

    // 検索リセット
    $('#reset_button').click(function(ev) {
        $('div#serach_box').find('input').val('');
        $('div#serach_box').find('input').prop('checked', false);
    });

    // ソート
    $('.sort').click(function(ev) {
        var sort_col_new = $(this).next('input[type="hidden"]').val();
        var sort_col_old = $('#col').val();
        var sort_key = $('#key').val();

        if (sort_key == 'DESC' || sort_col_old != sort_col_new) {
            $('#key').val('ASC');
        }else{
            $('#key').val('DESC');
        }

        $('#col').val(sort_col_new);
        $('#form').submit();
    });

    // ソート初期値
    var sort_col = $('#col').val();
    var sort_key = $('#key').val();
    if (sort_key == 'ASC') {
        $('#sort_'+sort_col).append('<span id="mark">▼</span>');
    }else{
        $('#sort_'+sort_col).append('<span id="mark">▲</span>');
    }

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