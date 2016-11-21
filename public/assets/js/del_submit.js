$(function() {
    // ファイル選択でアップロード開始
    $('#delete_button').click(function(ev) {
        if (window.confirm('Delete it?')) {
            $('form[name=delete_form]').submit();
        }
    });
});