<form action="/login/signup.php" method="post">
  <h2>회원 가입</h2>
  <div class="form-group">
    <label for="username">학번</label>
    <input type="text" id="username" name="username" class="form-control" placeholder="학번" required>
  </div>
  <div class="form-group">
    <label for="name">이름</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="이름" required>
  </div>
  <div class="form-group">
    <label for="password">비밀번호</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" required>
  </div>
  <div class="form-group">
    <label for="phone">전화번호</label>
    <input type="tel" id="phone" name="phone" class="form-control" placeholder="전화번호" required>
  </div>
  <div class="form-group">
    <input type="submit" value="회원가입">
  </div>
</form>  