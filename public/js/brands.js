$(function(){
    // xoa brand
    $('.js-delete-brand').click(function() {
        // can biet xoa thuong hieu nao thong qua id
        // lay gia tri id tuong ung khi click vao button

        let self = $(this); // chinh la button dang thao tac
        let id = self.attr('id'); // gia tri id
        //console.log(id);
        if($.isNumeric(id)) {
            // thuc su id phai la so
            // xu ly call ajax de xoa thuong hieu
            $.ajax({
                url: "index.php?c=brand&m=delete", // action trong form
                type: "POST", // method trong form
                data: { idBrand: id }, // du lieu gui di,
                beforeSend: function(){
                    // truoc khi gui du lieu di xu ly
                    // thong bao hieu ung loading - cho xu ly
                    self.text('Loading...');
                },
                success: function(result){
                    // nhan ket qua tu ben phia backend server tra ve thong qua bien result ma minh da khai bao
                    result = $.trim(result); // xoa khoang trang 2 dau
                    if(result === 'FAIL'){
                        alert('Co loi xay ra vui long thu lai');
                    } else if(result === 'OK') {
                        // thanh cong
                        alert('Xoa thanh cong');
                        // an dong vua click xoa
                        $('#js-brand-'+id).hide();
                    }
                    return false;
                }
            }); 
        } else {
            alert('Co loi xay ra vui long thu lai');
        }
    });

    // tim kiem brand
    $('#js-searchBrand').click(function(){
        // lay tu khoa nguoi dung tim kiem
        let keyword = $('#js-nameBranch').val().trim();
        if(keyword.length > 0){
            window.location.href = "index.php?c=brand&s="+keyword;
        }
    });
});