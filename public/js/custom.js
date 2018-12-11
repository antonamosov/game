$(document).ready(function() {
    const selVal = $( "#type" ).val();
    $('#type-select').toggle(selVal === 'select');
    $('#type-text').toggle(selVal === 'text');
    $('#type').on('change', function() {
        $('#type-select').toggle(this.value === 'select');
        $('#type-text').toggle(this.value === 'text');
    });
});