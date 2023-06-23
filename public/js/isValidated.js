//Các hàm để reset các input trong form khi được validated theo cách riêng như email không được trùng, mật khẩu không được quá ngắn.
function isInvalid(input) {
    $('#' + input).addClass('is-invalid');
    $('#' + input).css("border-color", "#dc3545");
    $('#' + input).css("background", "#FFFFFF");
    changeInput(input);
}

function isValid(input) {
    $('#' + input).removeClass('is-invalid');
    $('#' + input).css("border-color", "#dee2e6");
    $('#' + input).css("background", "#FFFFFF");

}
function changeInput(input) {
    $('#' + input).on('input', function () {
        if ($('#' + input)[0].checkValidity()) {
            $('#' + input + 'Error').empty();
            isValid(input);
        }
    });
}
//End