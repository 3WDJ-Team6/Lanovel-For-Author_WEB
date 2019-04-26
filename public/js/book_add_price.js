function commas(t) {

    // 콤마 빼고 

    var x = t.value;

    x = x.replace(/,/gi, '');



    // 숫자 정규식 확인

    var regexp = /^[0-9]*$/;

    if (!regexp.test(x)) {

        $(t).val("");

        alert("숫자만 입력 가능합니다.");

    } else {

        x = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        $(t).val(x);

    }

}
