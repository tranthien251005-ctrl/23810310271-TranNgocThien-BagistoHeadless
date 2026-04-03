# Bagisto Headless Commerce - Bài tập thực hành

**MSSV:** 23810310271
**Họ tên:** Trần Ngọc Thiện
**Ngày thực hiện:** 03/04/2026

---

## 1. MỤC TIÊU

- Nắm vững kiến trúc **Headless Commerce** (tách biệt Front-end và Back-end)
- Cài đặt thành công **Headless Extension** trên nền tảng Bagisto (Laravel)
- Thực hiện truy vấn dữ liệu tùy biến thông qua **GraphQL Playground**
- Xây dựng ứng dụng hiển thị dữ liệu thực tế từ API

---

## 2. HÌNH ẢNH MINH HỌA

### Phần 1

![Phần 1](./screenshots/phan1.png.png)

### GraphQL Playground - Query tùy biến

![GraphQL Playground](./screenshots/phan2.png.png)

---

## 3. CÂU HỎI VÀ CÂU TRẢ LỜI

### Câu 1: So sánh sự khác biệt về lưu lượng dữ liệu (Payload) giữa việc dùng REST API (lấy tất cả) và GraphQL (chỉ lấy trường cần thiết) trong bài làm của em?

**Trả lời:**  
REST API trả về toàn bộ fields của sản phẩm (id, name, description, price, images, created_at, updated_at, meta_title, meta_description...), dù chỉ cần 2-3 field. GraphQL chỉ trả đúng các field được yêu cầu (vd: chỉ name và price). Kết quả: Payload GraphQL nhẹ hơn **60-80%**, giảm băng thông, tăng tốc độ tải trang.

### Câu 2: Nếu muốn thay đổi giá của một sản phẩm qua Headless API, em sẽ sử dụng loại hành động nào trong GraphQL (Query hay Mutation)? Giải thích tại sao?

**Trả lời:**  
Sử dụng **Mutation**. Vì Mutation được thiết kế cho các thao tác **ghi dữ liệu** (Create, Update, Delete) - có thể thay đổi trạng thái server. Query chỉ dùng để **đọc dữ liệu**, không thay đổi dữ liệu trên server. Thay đổi giá sản phẩm là hành động cập nhật (Update), bắt buộc dùng Mutation để đảm bảo đúng ngữ nghĩa GraphQL và bảo mật.
