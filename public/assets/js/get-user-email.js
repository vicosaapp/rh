$(document).ready(function() {
    $('select[name="name"]').on('change', function() {
        var selected = $(this).find('option:selected');
        var email = selected.data('email');
        var ref = selected.data('ref');
        
        $('input[name="email"]').val(email);
        $('input[name="ref"]').val(ref);
    });
}); 