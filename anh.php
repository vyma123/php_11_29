<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css"  />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <style>
        /* CSS cho hộp thoại xác nhận tùy chỉnh */
        .confirmation-dialog {
            display: none; /* Hộp thoại ban đầu ẩn */
            position: fixed;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0; /* Ban đầu ẩn */
            transition: top 5s ease, opacity 3s ease; /* Thêm hiệu ứng chuyển động */
            max-width: 35rem;
        }

        /* CSS khi hộp thoại hiển thị */
        .confirmation-dialog.show {
            top: 15%; /* Vị trí hiển thị */
            opacity: 1; /* Đảm bảo hộp thoại hiển thị rõ ràng */
            display: block; /* Hiển thị hộp thoại */
        }

        .confirmation-dialog button {
            margin: 5px;
        }

        .box_text_delete{
    display: flex ;
    align-items: flex-start;
}

.text_delete{
    margin-left: 1rem;
}

.box_text_delete i{
    font-size: 1.5rem;
    margin: 0;
    --tw-text-opacity: 1;
    color: rgb(220 38 38 / var(--tw-text-opacity));
}

.box_delete_icon{
    width: 2.5rem;
    height: 2.5rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: red;
    --tw-bg-opacity: 1;
    background-color: rgb(254 226 226 / var(--tw-bg-opacity));
    border-radius: 50%;
}

.text_delete h3{
    --tw-text-opacity: 1;
    color: rgb(17 24 39 / var(--tw-text-opacity));
    line-height: 1.5rem;
    font-weight: 500;

}

.top_delete{
    padding: 1.5rem;
    padding-bottom: 1rem;
    --tw-bg-opacity: 1;
    background-color: rgb(254 242 242 / var(--tw-bg-opacity));
}

.bottom_delete{
    display: flex;
    flex-direction: row-reverse;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;

}

.confirm{
    font-size: .875rem;
    line-height: 1.25rem;
    margin-right: 0.75rem;
    width: auto;
    display: inline-flex;
    justify-content: center;
    --tw-text-opacity: 1;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid rgba(0, 0, 0, 0);
    cursor: pointer;

}

.confirm-yes{
    color: rgb(255 255 255 / var(--tw-text-opacity));
    background-color: rgb(220, 38, 38);

}

.confirm-yes:hover {
    --tw-bg-opacity: 1;
    background-color: rgb(185 28 28 / var(--tw-bg-opacity));
}

.confirm-no{
    background-color: #fff;
    border: 1px solid rgb(209, 213, 219);
}

.overlay {
    display: none; /* Ẩn lớp phủ ban đầu */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    --tw-bg-opacity: .5;
    background-color: rgb(0 0 0 / var(--tw-bg-opacity));
    z-index: 999; /* Đảm bảo lớp phủ hiển thị trên cùng */
    justify-content: center;
    align-items: center;
}

.overlay.show {
    display: flex; /* Hiển thị lớp phủ khi được kích hoạt */
}

.confirmation-dialog {
    z-index: 1000; /* Hộp thoại xác nhận nằm trên lớp phủ */
}
    </style>
</head>
<body>

    <button class="delete_button">Delete</button>

    <button class="delete_buttons">Delete All</button>
    
    <div class="overlay">
    <!-- Hộp thoại xác nhận xóa -->
    <div class="confirmation-dialog">
        <div class="top_delete">
            <div class="box_text_delete">
                <div class="box_delete_icon">
                    <i class="exclamation triangle icon"></i>
                </div>
                <div class="text_delete"> 
                    <h3>Delete Confirmation</h3>
                    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
                </div>
            </div>
        </div>
        <div class="bottom_delete">
            <button class="confirm-no confirm">Cancel</button>
            <button class="confirm-yes confirm">Delete</button>
        </div>
    </div>
    </div>

<script>

$(document).on('click', '.delete_button', function(e) {
    $('.overlay').addClass('show'); // Hiển thị lớp phủ
    $('.confirmation-dialog').addClass('show'); // Hiển thị hộp thoại

   console.log('one');

});

$(document).on('click', function(event) {
    if (!$(event.target).closest('.confirmation-dialog, .delete_button, .delete_buttons').length) {
        $('.confirmation-dialog').removeClass('show'); // Tắt hộp thoại nếu người dùng bấm ngoài
        $('.overlay').removeClass('show'); // Ẩn lớp phủ
    }
});
$(document).on('click', '.delete_buttons', function(e) {
    $('.overlay').addClass('show'); // Hiển thị lớp phủ
    $('.confirmation-dialog').addClass('show'); // Hiển thị hộp thoại

   console.log('all');
   
});




</script>

</body>
</html>
