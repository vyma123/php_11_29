Quản lý sản phẩm PHP
Mô tả các chức năng:
- xây dựng trong xampp.
- thư viện: css - semantic, jquery.
- cấu trúc tên folder + sql: {họ tên}_ {php/sql}.
- yêu cầu: khônng reload trang ở bất kỳ chức năng nào.
- tạo trang quản lý sản phẩm như ảnh, phân trang 5sp / trang.
- Khi click nút add product / add property / icon edit ở cột action:
+ hiển thị popup cho phép nhập các thông tin của sản phẩm theo tính
năng tương ứng( icon edit: hiện popup edit thông tin sản phẩm, add
property: tạo category hoặc tag cho database, add product: popup
nhập thông tin sản phẩm mới ).
+ Validate các giá trị vừa nhập khi click nút lưu (yc: name không được để
trống; SKU là unique, tự động tạo nếu khách không nhập, yêu cầu k được
phép chứa các ký tự đặc biệt ngoại trừ 2 dấu - và _ )
lưu thông tin vào database sau khi validate.
- (1): hiện khi hover vào bảng. xóa tất cả sản phẩm trong database sau
khi conrm.
- Khi click icon xóa ở cột action: xóa sản phẩm đó. yêu cầu hỏi trước khi
xóa.
- Khi click nút Filter : tìm kiếm sản phẩm theo các đều kiện đã chọn theo
điều kiện AND.( category/ tag: multi select ).
- Ô search: tìm kiếm khi nhập tên hoặc SKU của sản phẩm, độ trễ
400ms( lưu ý: cancel request đang thực hiện nếu gọi request mới)
- khi click nút (2): request lấy thông tin của sản phẩm
https:/ /aliexpress.ru/item/1005007662056562.html :
- tạo các sản phẩm từ các sản phẩm con của sản phẩm trên, tên sp được
tạo = tên sản phẩm cha + tên các atribute; ảnh feature của các sản
phẩm đươc tạo là ảnh của sản phẩm con tương ứng.
- Lấy theo ngôn ngữ en, convert giá sang USD theo tỷ lệ 1RUB = 0.01USD
- Update thông tin theo website nếu sp đã tồn tại
Getting started: 
…
